<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <div class="max-w-prose">
        <h2 class="text-2xl text-darkblue font-semibold mb-3">Add new question</h2>
        <p class="text-xl">People keep asking questions, and we keep providing answers.</p>
        <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">

            <?= $this->Form->create($question) ?>
            <?php
            echo $this->Form->control('title', ['class' => 'form-field', 'label' => 'Question']); ?>
            <div class="mt-2"><?php echo $this->Form->control('content', ['class' => 'form-field',  'label' => 'Answer']); ?></div>
            <div class="mt-2"> <?php echo $this->Form->control('status_id', ['options' => $statuses, 'empty' => true, 'class' => 'form-field text-base']);
                                ?></div>
            <div class="mt-4">
                <?= $this->Form->button(__('Add question'), ['class' => 'px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg']) ?>
                <?= $this->Form->end() ?></div>
        </div>
    </div>
</div>
<!-- TODO Allan add back summernote wysiwyg? -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="/js/summernote-cleaner.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['media', 'link', 'hr']],
                ['cleaner', ['cleaner']], // The Button
                ['view', ['codeview']],
            ],
            cleaner: {
                action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<br>', // Summernote's default is to use '<p><br></p>'
                notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                icon: '<i class="fas fa-broom"></i>',
                keepHtml: false, // Remove all Html formats
                keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>', '<i>', '<a>'], // If keepHtml is true, remove all tags except these
                keepClasses: false, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                badAttributes: ['style', 'start'], // Remove attributes from remaining tags
                limitChars: false, // 0/false|# 0/false disables option
                limitDisplay: 'both', // text|html|both
                limitStop: false // true/false
            }
        });
    });
</script>