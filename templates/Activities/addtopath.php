<?php
$this->loadHelper('Authentication.Identity');
$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">
        Add Activity to <a href="/pathways/<?= $pathway[0]->slug ?>" class="underline"><?= $pathway[0]->name ?></a>
    </h2>
    <div class="max-w-prose">

        
        <?php if (!empty($activity)) : ?>


            <div class="max-w-prose flex justify-between gap-4 border-2 p-3 rounded-md my-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle-fill flex-none" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </svg>
                <div class="grow">
                    <h3 class="mb-3 text-xl font-semibold">Existing Activity</h3>
                    <?php if($dupealert): ?>
                        <h4 class="font-semibold">This activity is already on this pathway.</h4>
                    <p class="mb-0">You <em>can</em> add it again to 
                        a step that it's not already on, but please be mindful of unecessary repetition.</p>
                    <?php else: ?>
                    <p class="mb-0">This activity already exists in the Curator. Let's add it to your step.</p>
                    <?php endif ?>
                </div>
            </div>
            <div class="w-full inline-block mb-3 p-0.5 rounded-md bg-sagedark hover:bg-sagedark/80 ">
                <div class="flex flex-row justify-between">
                    <i class="<?= h($activity[0]->activity_type->image_path) ?> mx-3 my-4 flex-none" style="color:white; font-size: 2rem;" aria-label="<?= h($activity[0]->activity_type->name) ?>"></i>
                    <div class="bg-white inset-1 rounded-r-sm flex-1">
                        <div class="p-3 text-lg">
                            <h4 class="mb-2 mt-1 text-xl font-semibold">
                                <?= h($activity[0]->name) ?>
                            </h4>
                            <div class="">
                                <?php if (!empty($activity[0]->description)) : ?>
                                    <p><?= h($activity[0]->description) ?></p>
                                <?php else : ?>
                                    <p><em>No description provided&hellip;</em></p>
                                <?php endif ?>
                            </div>
                            <?php if (!empty($activity[0]->_joinData->stepcontext)) : ?>
                                <div class="text-sm italic mt-2">
                                    Curator says:
                                    <blockquote class="border-l-2 p-2 m-2"><?= $activity[0]->_joinData->stepcontext ?></blockquote>
                                </div>
                            <?php endif ?>
                            <?php if (!empty($activity[0]->isbn)) : ?>
                                <p class="mt-2 mb-0">ISBN: <?= $activity[0]->isbn ?></p>
                            <?php endif ?>
                        </div>
                    </div> <!-- end white inner box -->
                </div>
            </div>
            <div class="ml-8">
                <h4 class="font-semibold text-xl mt-3">Activity Details</h4>
                <ul class="list-disc pl-8 mt-2">
                    <li class="px-2"><strong>Activity added:</strong> <?= $this->Time->format($activity[0]->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?> </li>
                    <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                        <li class="px-2"><strong>Added by:</strong> <a href="/users/view/<?= $activity[0]->createdby_id ?>"><?= $activity[0]->username ?></a></li>
                    <?php endif ?>
                    <li class="px-2" x-data="{ input: '<?= $activity[0]->hyperlink ?>', tooltip: 'Click to copy link', showMsg: false }"><strong>Hyperlink: </strong>
                        <?= $activity[0]->hyperlink ?> <button @click="$clipboard(input), showMsg = true" class="bg-sky-700 text-white rounded-lg py-1 px-2 text-base hover:cursor-pointer hover:bg-sky-700/80"><i class="" :class="{'bi bi-clipboard2 ': !showMsg, 'bi bi-clipboard2-check': showMsg }" alt="Copy link"></i> <span x-show="!showMsg">Copy link</span><span x-cloak x-show="showMsg">Copied!</span></button></li>
                </ul>
                <?php if (!empty($activity[0]->steps)) : ?>
                    <h4 class="font-semibold text-xl mt-5">Related Pathways</h4>
                    <p class="mb-2">This activity is included in the following pathways:</p>
                    <ul class="list-disc pl-8 mb-5">
                        <?php foreach ($activity[0]->steps as $step) : ?>
                            <?php if (!empty($step->pathways[0]->slug)) : ?>
                                <li class="px-2">
                                    <a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
                                        <?= $step->pathways[0]->name ?> - <?= $step->name ?>
                                    </a>
                                </li>
                            <?php else : ?>
                                <div><em>Not currently included on a pathway&hellip;</em></div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
            <div class="max-w-prose outline outline-1 outline-slate-500 p-6 my-3 rounded-md block">

                <h3 class="mb-3 text-xl font-semibold">Step 1: Add this activity to a step</h3>
                <div class="my-2 p-3 bg-slate-100 shadow-sm">
                <label>Steps on <a href="/pathways/<?= $pathway[0]->slug ?>" class="underline"><?= $pathway[0]->name ?></a> pathway:<br>
                <select class="m-3" id="stepselect">
                    <option>Select a step to proceed</option>
                <?php foreach ($pathway[0]->steps as $step) : ?>
                <?php if(!in_array($step->id,$onsteps)): // exclude the step the acitivity is already on ?>
                    <option class="stepid px-1" value="<?= $step->id ?>">
                        <?= $step->name ?>
                    </option>
                <?php endif ?>
                <?php endforeach ?>
                </select>
                </label>
                </div>
                <script>
                    let stepselect = document.querySelector('#stepselect');
                    
                    stepselect.addEventListener('change', (e) => { 
                        e.preventDefault();
                        let sid = e.target.value;
                        console.log(sid);
                        document.querySelector('#step_id').value = sid;
                        document.querySelector('.addtostep').classList.remove('opacity-25');
                        
                    });
                    
                </script>

                <?= $this->Form->create(null, 
                                        [
                                            'url' => ['controller' => 'activities-steps', 'action' => 'add', 'disabled' => 'disabled'],
                                            'class' => 'addtostep opacity-25'
                                        ]) ?>

                <?= $this->Form->hidden('step_id', ['value' => 0, 'id' => 'step_id']) ?>
                <?= $this->Form->hidden('activity_id', ['type' => 'hidden', 'value' => $activity[0]->id]) ?>
                <?= $this->Form->hidden('addtopath', ['type' => 'hidden', 'value' => 1]) ?>
                <div class="mb-3">
                <label>
                        <h4 class="font-semibold">Step 2: Required or Supplemental?</h4> Is this activity required for the step?
                        <?= $this->Form->checkbox('required', ['label' => 'Is this activity required for the step?', 'checked' => 'checked']) ?>
                    </label>
                    <div class="text-slate-600 mb-1 text-sm" id="reqorsuppContext">
                        <i class="bi bi-info-circle"></i> 
                        When a learner launches a supplemental activity it does not count towards their progress
                        along the pathway. Only required activities "count". </div>
                </div>
                <div class="mb-3">

                <label for="stepcontext">
                    <h4 class="font-semibold mt-2">Optional Step 3: Add Curator context</h4>
                    <span class="text-slate-600 block mb-1 text-sm" id="curatorContext">
                        <i class="bi bi-info-circle"></i> 
                        This is where you’ll add what the learners will do, need to pay attention to, etc. 
                        Elaborate on the context—why you chose this item for this step/pathway. Example: 
                            “Just read pages 20-34 of this chapter, which sheds light on how you can adopt 
                            a servant leadership approach.” </span>

                    <?= $this->Form->textarea('stepcontext', ['class' => 'form-field mb-2', 'rows' => 2]) ?>
                </label>
                </div>
                <?= $this->Form->button(__('Assign to step'), ['class' => 'mt-3 block px-4 py-2 text-white text-md bg-slate-700  hover:bg-slate-700/80 focus:bg-slate-700/80 hover:no-underline rounded-lg']) ?>
                <?= $this->Form->end() ?>
                

            </div>
        <?php else : ?>















            <div id="linkdeets">
                <div class="max-w-prose flex justify-between gap-4 border-2 p-3 rounded-md my-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle-fill flex-none" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>
                    <div class="grow">
                        <h3 class="mb-3 text-xl font-semibold">Fetching details&hellip;</h3>
                        <div id="loading">
                            <p class="mb-0">Hang on while we automagically fetch the link details for you.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-prose outline outline-1 outline-slate-500 p-6 my-3 rounded-md block">

                <h3 class="mb-3 text-xl font-semibold">Step 1: Add this activity to a step</h3>
                <div class="my-2 p-3 bg-slate-100 shadow-sm">
                <label>Steps on <a href="/pathways/<?= $pathway[0]->slug ?>" class="underline"><?= $pathway[0]->name ?></a> pathway:<br>
                <select class="m-3" id="stepselect">
                    <option>Select a step to proceed</option>
                <?php foreach ($pathway[0]->steps as $step) : ?>
                    <option class="stepid px-1" value="<?= $step->id ?>">
                        <?= $step->name ?>
                    </option>
                <?php endforeach ?>
                </select>
                </label>
                </div>
                <script>
                    let stepselect = document.querySelector('#stepselect');
                    
                    stepselect.addEventListener('change', (e) => { 
                        e.preventDefault();
                        let sid = e.target.value;
                        console.log(sid);
                        document.querySelector('#step_id').value = sid;
                        document.querySelector('.addform').classList.remove('opacity-25');
                        
                    });
                    
                </script>
                
                <div class="addform mt-3 opacity-25">
                    <h4 class="mb-3 font-semibold">Step 2: Review activity details</h4>
                    <?= $this->Form->create(null, ['url' => ['controller' => 'Activities', 'action' => 'addacttostep'], 'id' => 'addacttostep']) ?>
                    <?php
                    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-field']);
                    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-field']);
                    echo $this->Form->hidden('step_id', ['value' => 0, 'id' => 'step_id']);
                    ?>
                    
                    <div class="my-2"><?php echo $this->Form->control('activity_types_id', 
                                                                                    [
                                                                                        'options' => $activityTypes, 
                                                                                        'class' => 'form-field', 
                                                                                        'label' => 'Select an activity type:'
                                                                                    ]); ?>
                    </div>
                    <div class="mt-2"><?php echo $this->Form->control('hyperlink', ['class' => 'form-field', 'value' => $linktoact, 'Review the hyperlink, name and description:']); ?></div>
                    <div class="mt-2"><?php echo $this->Form->control('name', ['class' => 'form-field newname']); ?></div>
                    <div class="mt-2"><label for="description">Activity Description</label>
                        <span class="text-slate-600 block mb-1 text-sm" id="descriptionHelp">
                            <i class="bi bi-info-circle"></i> 
                            You can replace the automated description text with your own. 
                            Keep the description general and not specific to your pathway. 
                            This field will be displayed every time the item is included 
                            in a pathway everywhere in the Curator—not just on the step to 
                            which you add it.
                        </span>
                        <?php echo $this->Form->textarea('description', ['class' => 'form-field note-editable']) ?>
                    </div>


                    <?= $this->Form->button(__('Save Activity'), ['class' => 'mt-3 block px-4 py-2 text-white text-md bg-slate-700  hover:bg-slate-700/80 focus:bg-slate-700/80 hover:no-underline rounded-lg savebut']) ?>
                    <?= $this->Form->end() ?>
                </div>
                <div id="savestatus"></div>

                <div id="scontext" class="opacity-25 mt-3">

                    <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'edit/'], 'class' => 'contextform']) ?>
                    <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => 1, 'id' => 'actid']) ?>
                    <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => 1]) ?>
                    <label class="mt-2">
                        <h4 class="font-semibold">Step 3: Required or Supplemental?</h4> Is this activity required for the step?
                        <?= $this->Form->checkbox('required', ['label' => 'Is this activity required for the step?', 'checked' => 'checked']) ?>
                    </label>
                    <div class="text-sm">When a learner launches a supplemental activity it does not count towards their progress
                        along the pathway. Only required activities "count".</div>

                    <label for="stepcontext">
                        <h4 class="font-semibold mt-2">Optional Step 4: Add Curator context</h4>
                        <span class="text-slate-600 block mb-1 text-sm" id="curatorContext">
                            <i class="bi bi-info-circle"></i> 
                            This is where you’ll add what the learners will do, need to pay attention to, etc. 
                            Elaborate on the context—why you chose this item for this step/pathway. Example: 
                                “Just read pages 20-34 of this chapter, which sheds light on how you can adopt 
                                a servant leadership approach.” </span>

                        <?= $this->Form->textarea('stepcontext', ['class' => 'form-field mb-2', 'rows' => 2]) ?>
                    </label>

                    <button class="mt-3 px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80 hover:no-underline rounded-lg block addcon">
                        Add context and proceed
                    </button>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        <?php endif ?>












        
    </div>
    <div class="bg-bluegreen/30 p-3 rounded-md text-base">
        <p><strong>Bookmarklet:</strong> Drag the "Add to Curator" button to your bookmarks bar to save it as a shortcut. </p>
        <div class="my-3">
        <a class="px-4 whitespace-nowrap w-40 overflow-hidden text-ellipsis py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80 hover:no-underline rounded-lg" 
                rel="bookmarklet" 
                href="javascript: (() => {const destination = 'https://learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca/activities/addtopath?pathwayid=<?= $pathway[0]->id ?>&url=' + window.location.href;window.open(destination);})();"
                title="Drag to bookmarks bar or right-click and add to bookmarks">
                    Add to <?= $pathway[0]->name ?> Bookmarklet
            </a>
                            </div>
        <p>A "bookmarklet" is a special type of bookmark that allows you to take special action when you click it.
             In this case, if you click the "Add to Curator" bookmarklet while visiting any website, you will open 
             up this "Add to Step" form, with the link to that page pre-populated, saving you from having to copy the 
             URL and paste it here manually; furthermore, after you add a link to this page, the system will automatically 
             reach out to that page and attempt to bring in its title and description (based on its meta tags).</p>
    </div>
</div>







<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>

<script>
    $(function() {
        // LOL a year later looking at this I deserve some sort of medal for this crap:
        $("#loading").fadeOut(800).fadeIn(800).fadeOut(800).fadeIn(800).fadeOut(800).fadeIn(800).fadeOut(800);

        

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
                        descr = 'No description found.';
                    } else {
                        descr = deets.description;
                    }
                    $('.note-editable').html(descr);
                    $('#linkdeets').html('<div class="max-w-prose outline outline-1 outline-slate-500 p-6 my-3 rounded-md block"><h3 class="text-xl font-semibold mb-1">Automated Activity Details</h3><p class="mb-2"><strong>Title:</strong> ' + deets.title + '</p><p class="mb-2"><strong>Description:</strong> ' + descr + '</p><p class="mb-0"><strong>Hyperlink:</strong> ' + '<?= urldecode($linktoact) ?>' + '</p></div>');
                },
                statusCode: {
                    403: function() {
                        // oh no
                    }
                }
            });




        <?php endif ?>





        $('#addacttostep').on('submit', function(e) {

            e.preventDefault();
            let form = $(this);
            let url = $(this).attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function(data) {
                    console.log(data);
                    let deets = $.parseJSON(data);
                    console.log(deets.activitystepid);
                    $('.contextform').attr('action', '/activities-steps/edit/' + deets.activitystepid);
                    $('#actid').val(deets.activityid);
                    $('#step-id').val(deets.stepid);
                    $('#addacttostep').addClass('opacity-25');
                    $('#scontext').removeClass('opacity-25');
                    let message = '<div style="background: #F1F1F1; border-radius: 5px; margin: 1em 0; padding: 1em;">';
                    message += 'Your activity has been saved to the step! Please proceed.';
                    message += '</div>';
                    $('#savestatus').html(message);
                    $('.savebut').remove();
                },
                error: function (error) {
                    console.log('Nope it did not work');
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