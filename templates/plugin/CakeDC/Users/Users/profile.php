<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
    <h1 class="py-5">
    <?=
        $this->Html->tag(
            'span',
            __d('cake_d_c/users', '{0} {1}', $user->first_name, $user->last_name),
            ['class' => 'full_name']
        )
        ?>
    </h1>
</div>
</div>
</div>
<div class="container">
<div class="row justify-content-md-center">
<div class="col-md-8">
    <h2 class="my-5">Pathways</h2>
</div>
</div>
</div>