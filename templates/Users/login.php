<div class="row justify-content-md-center">

<div class="col-md-4">

<div class="card">
<div class="card-body">
   
    <?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->control('password', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-dark btn-block mt-3']); ?>
    <?= $this->Form->end() ?>
    <p class="mt-3">When you log in, you can follow pathways and claim activities!</p>
    
</div>
</div>
</div>
</div>