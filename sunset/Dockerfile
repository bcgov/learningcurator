FROM nginx:alpine

# Copy static assets to nginx's default public directory
COPY index.html /usr/share/nginx/html/index.html
COPY css /usr/share/nginx/html/css
COPY fonts /usr/share/nginx/html/fonts
COPY img /usr/share/nginx/html/img

# Create a simple nginx config that serves the page on port 8080
RUN echo 'server { \
    listen 8080; \
    server_name _; \
    root /usr/share/nginx/html; \
    index index.html; \
    location / { \
        try_files $uri $uri/ /index.html; \
    } \
}' > /etc/nginx/conf.d/default.conf

# Create nginx.conf that can run as non-root user (OpenShift compatibility)
RUN echo 'pid /tmp/nginx.pid; \
events { \
    worker_connections 1024; \
} \
http { \
    client_body_temp_path /tmp/client_temp; \
    proxy_temp_path /tmp/proxy_temp_path; \
    fastcgi_temp_path /tmp/fastcgi_temp; \
    uwsgi_temp_path /tmp/uwsgi_temp; \
    scgi_temp_path /tmp/scgi_temp; \
    include /etc/nginx/mime.types; \
    default_type application/octet-stream; \
    include /etc/nginx/conf.d/*.conf; \
}' > /etc/nginx/nginx.conf

# Set permissions for OpenShift
RUN chmod -R g+rwX /var/cache/nginx /var/run /var/log/nginx /tmp && \
    chmod -R g+rwX /usr/share/nginx/html

# Use port 8080 (non-privileged) for OpenShift compatibility
EXPOSE 8080

# Run nginx in foreground
CMD ["nginx", "-g", "daemon off;"]
