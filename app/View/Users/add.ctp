<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
            echo $this->Form->input('first');
            echo $this->Form->input('last');
            echo $this->Form->input('dob', array(
                'label' => 'Date of birth',
                'dateFormat' => 'MDY',
                'minYear' => date('Y') - 70,
                'maxYear' => date('Y') - 8,));
            echo $this->Form->input('email');
            echo $this->Form->input('password');
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>