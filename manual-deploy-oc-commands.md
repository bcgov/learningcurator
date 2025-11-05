# Manual Deployment Commands for Learning Curator Sunset Page

This document contains the OpenShift CLI (`oc`) commands to manually deploy the sunset page to any environment (dev, test, or production).

## Prerequisites

1. Install the OpenShift CLI (`oc`)
2. Have your OpenShift service account token ready
3. Be in the root directory of the learningcurator repository

## Environment Variables Setup

Before running the commands, set up the environment variables for your target environment:

### For Development (a58ce1-dev)
```bash
export NAMESPACE=a58ce1-dev
export BUILD_NAMESPACE=a58ce1-tools
export APP=learningcurator-sunset
export APP_HOST=learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca
export BRANCH=master
```

### For Test (a58ce1-test)
```bash
export NAMESPACE=a58ce1-test
export BUILD_NAMESPACE=a58ce1-tools
export APP=learningcurator-sunset
export APP_HOST=learningcurator-sunset-a58ce1-test.apps.silver.devops.gov.bc.ca
export BRANCH=master
```

### For Production (a58ce1-prod)
```bash
export NAMESPACE=a58ce1-prod
export BUILD_NAMESPACE=a58ce1-tools
export APP=learningcurator-sunset
export APP_HOST=learningcurator.gov.bc.ca
export BRANCH=master
```

## Deployment Steps

### 1. Login to OpenShift

```bash
oc login --token=YOUR_SA_TOKEN --server=https://api.silver.devops.gov.bc.ca:6443
```

Replace `YOUR_SA_TOKEN` with your actual service account token.

### 2. Build the Sunset Page Image (Optional if already built)

If you need to rebuild the sunset page image:

```bash
cd openshift/sunset

# Verify environment variables are set
test -n "${BRANCH}"
test -n "${BUILD_NAMESPACE}"

echo "BUILDING ${APP} with tag: latest"

# Process and apply the build configuration
oc -n ${BUILD_NAMESPACE} process -f docker-build.yml \
  -p TAG=latest \
  -p SOURCE_REPOSITORY_REF=${BRANCH} \
  -p SOURCE_CONTEXT_DIR=sunset \
  -p NAME=${APP} | oc -n ${BUILD_NAMESPACE} apply -f -

# Start the build and wait for completion
oc -n ${BUILD_NAMESPACE} start-build bc/${APP} --no-cache --wait

# Return to repository root
cd ../..
```

### 3. Archive the Legacy Learning Curator Deployment

This step scales down the old `learningcurator` deployment and removes its route and service:

```bash
# Verify environment variables are set
test -n "${NAMESPACE}"
test -n "${BUILD_NAMESPACE}"
test -n "${BRANCH}"

echo "Current namespace is ${NAMESPACE}"

# Scale down the old deployment (ignore errors if it doesn't exist)
echo "Archiving legacy learningcurator deployment (if present)..."
oc -n ${NAMESPACE} scale dc/learningcurator --replicas=0 || true

# Delete the old route and service
oc -n ${NAMESPACE} delete route learningcurator --ignore-not-found
oc -n ${NAMESPACE} delete service learningcurator --ignore-not-found
```

### 4. Deploy the Sunset Page

```bash
echo "Deploying static sunset page..."

# Grant image pull permissions
oc -n ${BUILD_NAMESPACE} policy add-role-to-group system:image-puller system:serviceaccounts:${NAMESPACE}

# Process and apply the sunset template
oc -n ${NAMESPACE} process -f openshift/sunset/sunset-template.json \
  -p APP_NAME=${APP} \
  -p SITE_URL=${APP_HOST} \
  -p PROJECT_NAMESPACE=${NAMESPACE} \
  -p BUILD_NAMESPACE=${BUILD_NAMESPACE} \
  -p IMAGE_STREAM_TAG="${APP}:latest" | \
oc -n ${NAMESPACE} apply -f -

# Wait a bit for resources to be created
sleep 30

# Trigger a new rollout
oc rollout latest dc/${APP} -n ${NAMESPACE}
```

### 5. Monitor the Deployment

```bash
# Check deployment rollout status every 10 seconds (max 10 minutes) until complete
ATTEMPTS=0
ROLLOUT_STATUS_CMD="oc rollout status dc/${APP} -n ${NAMESPACE}"
until $ROLLOUT_STATUS_CMD || [ $ATTEMPTS -eq 60 ]; do
  $ROLLOUT_STATUS_CMD
  ATTEMPTS=$((ATTEMPTS + 1))
  sleep 10
done
```

### 6. Verify the Deployment

```bash
# Switch to the namespace
oc project ${NAMESPACE}

# List pods
echo "Listing pods..."
oc get pods | grep ${APP}

# Get the route URL
export ROUTE="$(oc get route ${APP} -o jsonpath='{.spec.host}')"
echo "${APP} is exposed at https://${ROUTE}"
```

## Complete One-Liner Script

For convenience, here's a complete script that runs all commands in sequence. **Make sure to set the environment variables first!**

```bash
# Set environment variables first (choose dev, test, or prod section above)

# Then run this complete script:
oc login --token=YOUR_SA_TOKEN --server=https://api.silver.devops.gov.bc.ca:6443 && \
test -n "${NAMESPACE}" && \
test -n "${BUILD_NAMESPACE}" && \
test -n "${BRANCH}" && \
echo "Current namespace is ${NAMESPACE}" && \
echo "Archiving legacy learningcurator deployment (if present)..." && \
oc -n ${NAMESPACE} scale dc/learningcurator --replicas=0 || true && \
oc -n ${NAMESPACE} delete route learningcurator --ignore-not-found && \
oc -n ${NAMESPACE} delete service learningcurator --ignore-not-found && \
echo "Deploying static sunset page..." && \
oc -n ${BUILD_NAMESPACE} policy add-role-to-group system:image-puller system:serviceaccounts:${NAMESPACE} && \
oc -n ${NAMESPACE} process -f openshift/sunset/sunset-template.json \
  -p APP_NAME=${APP} \
  -p SITE_URL=${APP_HOST} \
  -p PROJECT_NAMESPACE=${NAMESPACE} \
  -p BUILD_NAMESPACE=${BUILD_NAMESPACE} \
  -p IMAGE_STREAM_TAG="${APP}:latest" | \
oc -n ${NAMESPACE} apply -f - && \
sleep 30 && \
oc rollout latest dc/${APP} -n ${NAMESPACE} && \
oc rollout status dc/${APP} -n ${NAMESPACE} && \
oc project ${NAMESPACE} && \
echo "Listing pods..." && \
oc get pods | grep ${APP} && \
export ROUTE="$(oc get route ${APP} -o jsonpath='{.spec.host}')" && \
echo "${APP} is exposed at https://${ROUTE}"
```

## Troubleshooting

### If the deployment fails:

1. **Check pod logs:**
   ```bash
   oc -n ${NAMESPACE} logs dc/${APP}
   ```

2. **Check pod status:**
   ```bash
   oc -n ${NAMESPACE} get pods
   oc -n ${NAMESPACE} describe pod <pod-name>
   ```

3. **Check deployment config:**
   ```bash
   oc -n ${NAMESPACE} get dc/${APP} -o yaml
   ```

4. **Check if image exists:**
   ```bash
   oc -n ${BUILD_NAMESPACE} get imagestream ${APP}
   ```

### To rollback a deployment:

```bash
oc -n ${NAMESPACE} rollback dc/${APP}
```

### To view deployment history:

```bash
oc -n ${NAMESPACE} rollout history dc/${APP}
```

## Notes

- The sunset page image is built in the `a58ce1-tools` namespace and shared across all environments
- The old `learningcurator` deployment is scaled to 0 but not deleted, allowing for potential recovery
- The sunset deployment uses minimal resources (64Mi-128Mi memory, 50m-200m CPU)
- The route uses edge TLS termination with automatic HTTP to HTTPS redirect
