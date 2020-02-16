<div class="row justify-content-md-center">

<div class="col-md-4">
<div class="card">
<div class="card-body">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
        <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
        <?= $this->Form->control('password', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->submit(__('IDIR Login'), ['class' => 'btn btn-success btn-block mt-3']); ?>
    <?= $this->Form->end() ?>
<p class="mt-3">When you log in, you can follow pathways and claim activities!</p>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-body">
<h1>Read, Watch, Listen, Particpate</h1>
<p>The Learning Agent shows you pathways that you can follow that will help you with your goals.</p>
<p>We have pathways in the following areas:</p>
<h1>Leadership</h1>
<div class="card mb-2">
<div class="card-body">
<h2>
<a href="/pathways/view/1">Personal Development</a></h2>
<div class="mb-3">
Achieve humility &amp; self-awareness. Receive and use feedback.</div>
</div>
</div>
<div class="card mb-2">
<div class="card-body">
<h2>
<a href="/pathways/view/2">Functions of Government</a></h2>
<div class="mb-3">
Can explain what the relationship is between understanding your ministry’s core functions &amp; leadership development.</div>
</div>
</div>
<div class="card mb-2">
<div class="card-body">
<h2>
<a href="/pathways/view/3">Role Advancement</a></h2>
<div class="mb-3">
Identify 3 key contacts to reach out to for. Describe the benefits of mentoring and identify potential candidates to mentor you. Access resources about mentoring. Apply networking best practices and establish new contacts/relationships.</div>
</div>
</div>
<div class="card mb-2">
<div class="card-body">
<h2>
<a href="/pathways/view/4">Leading Others</a></h2>
<div class="mb-3">
Understanding the elements of an effective communications/coaching approach that addresses… (include the three types here). Have career conversations with your direct reports.</div>
</div>
</div>


<img src="/img/learning_agent_logo.png">
</div>
</div>
</div>
</div>
