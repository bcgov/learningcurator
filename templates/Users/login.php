<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col">
<div class="p-3 m-3 bg-dark text-white rounded-3 shadow-sm">

   
    <?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->control('password', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-dark btn-block mt-3']); ?>
    <?= $this->Form->end() ?>
    
</div>
</div>
</div>
</div>