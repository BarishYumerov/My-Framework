<?php /** @model = LectureViewModel */?>
<div class="thumbnail col-lg-4 col-lg-offset-4" style="background: #333; padding: 10px; margin-right: 900px;">
    <form method="post" action="/Conference/<?php echo $this->getViewBag()['conferenceId'] ?>/Add/Lecture">
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="datetime" id="title"  name="name" class="form-control" />
        </div>

        <div class="form-group">
            <label for="start">Start Time: </label>
            <input type="datetime-local" id="start" name="startDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="end">End Time: </label>
            <input type="datetime-local" id="end" name="endDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="hall">Hall: </label>
            <select id="hall" name="hallId" class="form-control" >
                <?php foreach($this->getViewBag()['halls'] as $hall) : ?>
                    <option value="<?php echo $hall->getId() ?>" class=form-control">
                        <?php echo $hall->getName() ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <input type="submit" class="btn btn-default" value="Add" />
        <?php echo $this->getCsfrToken() ?>
    </form>
</div>
