<?php
$this->loadHelper('Authentication.Identity');
$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<!-- TODO Check with Allan about adding styling here -->

<div class="p-6">
    <div class="p-3 bg-slate-100/80 rounded-lg">






        <?php if (!empty($activity)) : ?>

            <div>This activity already exists in the Curator! Let's add that one to your step.</div>

            <div class="bg-white rounded-lg">
                <div class="p-3 my-3 rounded-lg activity" style="background-color: rgba(<?= $activity[0]->activity_type->color ?>,.2);">

                    <h3 class="my-3">
                        <a href="/activities/view/<?= $activity[0]->id ?>"><?= $activity[0]->name ?></a>
                        <!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity[0]->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
                    </h3>
                    <div class="p-3" style="background: rgba(255,255,255,.3);">
                        <div class="mb-3">
                            <?php foreach ($activity[0]->tags as $tag) : ?>
                                <a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a>
                            <?php endforeach ?>
                        </div>

                        <?= $activity[0]->description ?>
                        <?php if (!empty($activity[0]->isbn)) : ?>
                            <div class="bg-white p-2 isbn">
                                ISBN: <?= $activity[0]->isbn ?>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($activity[0]->_joinData->stepcontext)) : ?>
                            <div class="alert alert-light text-dark mt-3 shadow-sm">
                                <i class="bi bi-person-badge-fill"></i>
                                Curator says:<br>
                                <?= $activity[0]->_joinData->stepcontext ?>
                            </div>
                        <?php endif ?>
                        <div class="text-muted p-2 mt-2" style="background-color: rgba(255,255,255,.2)">
                            Added on
                            <?= $this->Time->format($activity[0]->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                                by <a href="/users/view/<?= $activity[0]->createdby_id ?>">curator</a>
                            <?php endif ?>
                        </div>
                        <div class="bg-white p-3">
                            Included in:
                            <?php foreach ($activity[0]->steps as $step) : ?>
                                <?php if (!empty($step->pathways[0]->slug)) : ?>
                                    <div>
                                        <a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
                                            <?= $step->pathways[0]->name ?> - <?= $step->name ?>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div><em>Not currently included on a pathway&hellip;</em></div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <a target="_blank" rel="noopener" data-toggle="tooltip" data-placement="bottom" title="Launch this activity" href="<?= $activity[0]->hyperlink ?>" style="background-color: rgba(<?= $activity[0]->activity_type->color ?>,1); color: #000; font-weight: bold;" class="btn btn-block my-3 text-uppercase btn-lg">
                        <?= $activity[0]->activity_type->name ?>
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>

            <div class="my-3 font-weight-bold">Find a pathway step to add the activity to:</div>
            <form method="get" id="pathfind" action="/pathways/find" class="form-inline mb-2">
                <label for="q">Find a pathway:</label>
                <input id="q" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
            <div id="results"></div>
            <div class="bg-light p-3 my-3">
                <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'add', 'disabled' => 'disabled']]) ?>
                <?php //$this->Form->control('pathway_id',['type' => 'hidden', 'value' => '' ]) 
                ?>
                <?= $this->Form->hidden('step_id', ['value' => 0, 'id' => 'step_id']) ?>
                <?= $this->Form->hidden('activity_id', ['type' => 'hidden', 'value' => $activity[0]->id]) ?>
                <?= $this->Form->control('stepcontext', ['class' => 'form-control summernote', 'label' => 'Set Context for this step']); ?>
                <div><label>Is this activity required for the step?
                        <?= $this->Form->checkbox('required', ['label' => 'Is this activity required for the step?']) ?>
                    </label></div>
                <?= $this->Form->button(__('Assign to step'), ['class' => 'btn btn-sm btn-success btn-block']) ?>
                <?= $this->Form->end() ?>
            </div>
        <?php else : ?>

            <div id="linkdeets">
                <strong>Hang on&hellip;</strong>
                <div id="loading">

                    <div class="bg-light p-3">Hang on while I fetch the details of this link for you.</div>
                </div>
            </div>

            <div class="my-3 font-weight-bold">Find a pathway step to add the activity to:</div>
            <form method="get" id="pathfind" action="/pathways/find" class="form-inline mb-2">
                <label for="q">Find a pathway:</label>
                <input id="q" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
            <div id="results"></div>

            <div class="addform mt-3 opacity-25">
                <div class="mb-3 font-weight-bold">Now fill in the activity details:</div>
                <?= $this->Form->create(null, ['url' => ['controller' => 'Activities', 'action' => 'addtostep'], 'id' => 'addacttostep']) ?>
                <?php
                echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-control']);
                echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-control']);
                echo $this->Form->hidden('step_id', ['value' => 0, 'id' => 'step_id']);
                ?>
                <div class="row my-3 text-center" id="acttypes">
                    <div class="col">
                        <a href="#watch" data-id="1" style="background-color: rgba(193,129,183,.2);">
                            <i class="bi bi-camera-video-fill"></i><br>
                            Watch
                        </a>
                    </div>
                    <div class="col">
                        <a href="#read" data-id="2" style="background-color: rgba(249,145,80,.2);">
                            <i class="bi bi-book-fill"></i><br>
                            Read
                        </a>
                    </div>
                    <div class="col">
                        <a href="#listen" data-id="3" style="background-color: rgba(244,105,115,.2);">
                            <i class="bi bi-headphones"></i><br>
                            Listen
                        </a>
                    </div>
                    <div class="col">
                        <a href="#participate" data-id="4" style="background-color: rgba(255,218,96,.2);">
                            <i class="bi bi-people-fill"></i><br>
                            Participate
                        </a>
                    </div>
                </div>
                <input type="hidden" name="activity_types_id" id="activity_types_id" value="2">
                <?php echo $this->Form->control('hyperlink', ['class' => 'form-control', 'value' => $linktoact]); ?>
                <?php echo $this->Form->control('name', ['class' => 'form-control form-control-lg newname']); ?>
                <label for="description">Description</label>
                <?php echo $this->Form->textarea('description', ['class' => 'form-control summernote']) ?>
                <?php //echo $this->Form->control('licensing', ['class' => 'form-control']); 
                ?>
                <?php //echo $this->Form->control('activity_type_id', ['class' => 'form-control', 'options' => $atypes]); 
                ?>
                <?php //echo $this->Form->control('stepcontext', ['class' => 'form-control', 'label' => 'Set Context for this step']); 
                ?>
                <?php //echo $this->Form->control('moderator_notes', ['class' => 'form-control']); 
                ?>
                <?php //echo $this->Form->control('isbn', ['class' => 'form-control']); 
                ?>
                <?php //echo $this->Form->control('status_id', ['class' => 'form-control', 'options' => $statuses, 'empty' => true]); 
                ?>
                <?php //echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text', 'label' => 'Tags']); 
                ?>
                <?php //echo $this->Form->control('users._ids', ['class' => 'form-control', 'options' => $users]); 
                ?>
                <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-control', 'options' => $competencies]); 
                ?>
                <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3 d-none savebut']) ?>
                <?= $this->Form->end() ?>

                <div id="scontext" class="opacity-25">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'edit/'], 'class' => 'contextform']) ?>
                    <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => 1, 'id' => 'actid']) ?>
                    <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => 1]) ?>
                    <?= $this->Form->control('stepcontext', ['class' => 'form-control', 'label' => 'Why are you adding this here?']) ?>
                    <div><label>Is this activity required for the step?
                            <?= $this->Form->checkbox('required', ['label' => 'Is this activity required for the step?']) ?>
                        </label></div>
                    <button class="btn btn-success addcon d-none">Add context to the activity</button>
                    <?= $this->Form->end() ?>
                </div>
            <?php endif ?>

            </div>
    </div>
    <div>
        <strong>Bookmarklet:</strong><br>
        <a class="btn btn-dark" href="javascript: (() => {const destination = 'https://learningcurator.apps.silver.devops.gov.bc.ca/activities/addtostep?url=' + window.location.href;window.open(destination);})();">
            Add to Curator
        </a>
    </div>
    <div class="">A "bookmarklet" is a special type of bookmark that allows you to take special action when you click it.
        In this case, if you click the "Add to Curator" bookmarklet while visiting any website, you will open up this
        "Add to Step" form, with the link to that page pre-populated, saving you from having to copy the URL and paste
        it here manually; furthermore, after you add a link to this page, the system will automatically reach out to that
        page and attempt to bring in its title and description (based on its meta tags).

    </div>
</div>


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>

<script>
    $(function() {

        $("#loading").fadeOut(800).fadeIn(800).fadeOut(800).fadeIn(800).fadeOut(800).fadeIn(800);
        //$("#loading").delay(5000).html('<div><strong>There seems to be something wrong. Please proceed and fill in the details yourself.</strong></div>');

        <?php if ($linktoact) : ?>

            console.log('GOOD TO GO');
            let geturl = '/activities/getinfo?url=<?= urlencode($linktoact) ?>';
            $.ajax({
                type: "GET",
                url: geturl,
                success: function(data) {
                    let deets = $.parseJSON(data);
                    $('.newname').val(deets.title);
                    let descr = '';
                    if (deets.description == '') {
                        descr = '<em>No description found.</em>';
                    } else {
                        descr = deets.description;
                    }
                    $('.note-editable').html(descr);
                    $('#linkdeets').html('<strong>Adding:</strong><br><div class="p-3 bg-light">' + deets.title + '<br>' + descr + '<br>' + '<?= urldecode($linktoact) ?></div>');
                },
                statusCode: {
                    403: function() {
                        // oh no
                    }
                }
            });


        <?php endif ?>

        $('#acttypes a').on('click', function(e) {
            e.preventDefault();
            let actid = $(this).data('id');
            $('#activity_types_id').val(actid);
            $(this).css('background-color', 'rgba(0,0,0,.5)')
            $(this).css('color', '#FFF')
        });

        $('#pathfind').on('submit', function(e) {

            e.preventDefault();
            let form = $(this);
            let url = $(this).attr('action');
            $.ajax({
                type: "GET",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    $('#results').html(data);
                },
                statusCode: {
                    403: function() {
                        form.after('<div class="alert alert-warning">You must be logged in.</div>');
                    }
                }
            });
        });

        $('#addacttostep').on('submit', function(e) {

            e.preventDefault();
            let form = $(this);
            let url = $(this).attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    console.log(data);
                    let deets = $.parseJSON(data);
                    console.log(deets.activitystepid);
                    $('.contextform').attr('action', '/activities-steps/edit/' + deets.activitystepid);
                    $('#actid').val(deets.activityid);
                    $('#step-id').val(deets.stepid);
                    $('#scontext').removeClass('opacity-25');
                    $('.addcon').removeClass('d-none');
                    $('.savebut').remove();
                }
            });
        });

        $('#hyperlink').on('change', function(e) {

            e.preventDefault();

            let urltoscrape = this.value;
            let url = '/activities/getinfo?url=' + urltoscrape;

            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    let deets = $.parseJSON(data);
                    $('.newname').val(deets.title);
                    let descr = '';
                    if (deets.description == '') {
                        descr = '<em>No description found.</em>';
                    } else {
                        descr = deets.description;
                    }
                    $('.note-editable').html(descr);
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