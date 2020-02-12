<div class="row justify-content-md-center">
<div class="col-md-4">
<div class="card">
<div class="card-body">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
        <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
        <?= $this->Form->control('password', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-success btn-block mt-3']); ?>
    <?= $this->Form->end() ?>
</div>
</div>
</div>
</div>
