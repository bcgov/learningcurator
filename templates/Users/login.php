<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">

<div class="col-md-4">

<div class="my-5 p-3 bg-white shadow-sm rounded-lg">

   <h1>Curator is currently invite-only</h1>
   <div class="alert alert-light my-3">It'll be open to everyone soon!</div>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->control('password', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-success btn-block mt-3']); ?>
    <?= $this->Form->end() ?>
    <p class="mt-3">When you log in, you can follow pathways and claim activities!</p>
    

</div>
</div>
</div>
</div>