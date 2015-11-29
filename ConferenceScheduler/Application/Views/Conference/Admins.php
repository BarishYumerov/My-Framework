<?php /** @model = AccountViewModel */?>
<div class="col-lg-offset-4 col-lg-5" style="margin-right: 600px; margin-bottom: 200px;">
    <?php if(count($model) > 0) : ?>
        <h2>Conference Admins: </h2>
        <?php foreach($model as $admin) : ?>
            <div>
                <p>
                    <b><u><?php echo strtoupper($admin->getUsername()); ?></u></b>
                    <a href="/Conference/<?php echo $this->getViewBag()['conferenceId'] ?>/Remove/Admin/<?php echo $admin->getId() ?>"
                       class="btn btn-danger btn-xs">Remove</a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <h2>This Conference Still Has No Admins: </h2>
    <?php endif; ?>

    <form class="col-lg-7" method="post" action="/Conference/<?php echo $this->getViewBag()['conferenceId'] ?>/Admins/Manage">
        <div class="form-group">
            <label for="username">Username: </label>
            <input id="username" name="username" type="text" class="form-control">
        </div>
        <input type="submit" class="btn btn-success btn-sm" value="Add Admin">
        <?php echo $this->getCsfrToken() ?>
    </form>
</div>
