<?php /** @model = LectureViewModel */?>
<div class="thumbnail col-lg-4 col-lg-offset-4" style="background: #333; padding: 10px; margin-right: 900px;">
    <form method="post" action="/Lecture/<?php echo $model->getId() ?>/Manage">
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="datetime" id="title" value="<?php echo $model->getName(); ?>" name="name" class="form-control" />
        </div>

        <div class="form-group">
            <label for="start">Start Time: </label>
            <input type="datetime" id="start" value="<?php echo $model->getStartDate(); ?>" name="startDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="end">End Time: </label>
            <input type="datetime" id="end" value="<?php echo $model->getEndDate(); ?>" name="endDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="hall">Hall: </label>
            <select id="hall" name="hallId" class="form-control" >
                <?php foreach($this->getViewBag()['halls'] as $hall) : ?>
                    <option value="<?php echo $hall->getId() ?>"
                            <?php if(intval($hall->getId()) == $model->getId())
                                echo 'selected="true"' ?>class=form-control">
                        <?php echo $hall->getName() ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <?php if($model->getSpeakers()) : ?>
            <div>
                <h4>Speakers: </h4>
                <?php foreach($model->getSpeakers() as $speaker): ?>
                    <p><?php echo $speaker->getUsername() ?>
                        <a href="/Lecture/<?php echo $model->getId() ?>/Remove/Speaker/<?php echo $speaker->getId() ?>"
                           class="btn btn-danger btn-xs pull-right">Remove</a></p>
                <?php endforeach ?>
            </div>
        <?php else : ?>
            <h4 style="color: #ff0000;">No speakers are assigned yet!</h4>
        <?php endif; ?>
        <a href="/Lecture/<?php echo $model->getId()?>/Invite/Speaker" class="btn btn-info">Invite a speaker!</a>
        <input type="submit" class="btn btn-default" value="Edit" />
    </form>
</div>
