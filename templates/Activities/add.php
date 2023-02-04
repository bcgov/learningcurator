<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Activity</h2>
    <div class="max-w-prose flex justify-between gap-4 border-2 p-3 rounded-md my-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle-fill flex-none" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </svg>
        <div class="grow">
            <h3 class="mb-3 text-xl font-semibold">Caution: Unassigned Activity</h3>
            <p>
                This form adds an activity without assigning it to a pathway step. If you add
                your activity this way, you will need to use the "Add existing activity" button on the step edit page.
            </p>
            <p class="mb-0"><strong>We recommend that you add your activities directly to a pathway step.</strong></p>
        </div>
    </div>


    <div class="max-w-prose border border-slate-500 p-6 my-3 rounded-md block">

        <?= $this->Form->create($activity) ?>
        <?php echo $this->Form->control('hyperlink', ['class' => 'form-field mb-3']); ?>
        <div id="linkcheck"></div>
        <?php
        if ($this->Form->isFieldError('hyperlink')) {
            echo $this->Form->error('hyperlink', 'This link may already exist in the system.');
        }
        ?>
        <?php
        // echo $this->Form->control('ministry_id', ['class' => 'form-field mb-3', 'options' => $ministries, 'empty' => true]);
        // echo $this->Form->control('category_id', ['class' => 'form-field mb-3', 'options' => $categories, 'empty' => true]);
        // echo $this->Form->control('approvedby_id', ['class' => 'form-field mb-3']);
        echo $this->Form->hidden('createdby_id', ['value' => $activity->createdby_id, 'class' => 'form-field mb-3']);
        echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-field mb-3']);
        ?>
        <?php echo $this->Form->control('name', ['class' => 'form-field mb-3 newname', 'label' => 'Activity Title']); ?>
        <label for="description">Activity Description</label>
        <span class="text-slate-600 block mb-1 text-sm" id="descriptionHelp"><i class="bi bi-info-circle"></i> You can replace the automated description text with your own. Keep the description general and not specific to your pathway. This field will be displayed every time the item is included in a pathway everywhere in the Curator—not just on the step to which you add it.</span>
        <?php echo $this->Form->textarea('description', ['class' => 'note-editable form-field mb-3']) ?>

        <?php //echo $this->Form->control('steps._ids', ['class' => 'form-field mb-3', 'options' => $steps]); 
        ?>
        <?php //echo $this->Form->control('licensing', ['class' => 'form-field mb-3']); 
        ?>
        <?php //echo $this->Form->control('moderator_notes', ['class' => 'form-field mb-3']); 
        ?>
        <?php echo $this->Form->control('isbn', ['class' => 'form-field mb-3', 'label' => 'ISBN']); ?>
        <?php echo $this->Form->control('activity_types_id', ['class' => 'form-field mb-3  text-base border', 'options' => $activityTypes]); ?>
        <?php echo $this->Form->control('status_id', ['class' => 'form-field mb-3 text-base border', 'options' => $statuses, 'empty' => true]); ?>
        <?php //echo $this->Form->control('tag_string', ['class' => 'form-field mb-3', 'type' => 'text', 'label' => 'Tags']); 
        ?>
        <?php //echo $this->Form->control('users._ids', ['class' => 'form-field mb-3', 'options' => $users]); 
        ?>
        <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-field mb-3', 'options' => $competencies]); 
        ?>
        <?= $this->Form->button(__('Save Activity'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700  hover:bg-slate-700/80 focus:bg-slate-700/80 hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>

<script>
    $(function() {

        $('#hyperlink').on('change', function(e) {

            e.preventDefault();

            let urlto = this.value;

            let checkurl = '/activities/linkcheck?search=' + urlto;
            $.ajax({
                type: "GET",
                url: checkurl,
                success: function(data) {
                    let foo = $.parseJSON(data);
                    if (foo[0]) {
                        if (foo[0].id) {
                            $('#linkcheck').html('This link already exists in the system.');
                        }
                    } else {
                        $('#linkcheck').html('');
                    }
                },
                statusCode: {
                    403: function() {
                        // oh no
                    }
                }
            });


            let infourl = '/activities/getinfo?url=' + urlto;
            $.ajax({
                type: "GET",
                url: infourl,
                success: function(data) {
                    let foo = $.parseJSON(data);
                    $('.newname').val(foo.title);
                    $('.note-editable').html(foo.description);
                },
                statusCode: {
                    403: function() {
                        // oh no
                    }
                }
            });
        });

    });
</script>