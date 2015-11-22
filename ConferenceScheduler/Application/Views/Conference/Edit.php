<?php /** @model = ConferenceBindingModel */?>
<div class="col-lg-12 login">
    <h2 class="col-lg-offset-4">Edit Conference:</h2>
    <form method="post" action="/Conference/<?php echo $model->getId() ?>/Edit" class="col-lg-3 col-lg-offset-4">
        <div class="form-group">
            <a class="btn btn-success btn-xs" href="/Conference/<?php echo $model->getId() ?>/Lectures/Manage">Manage Lectures</a>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo $model->getTitle(); ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="startDate">Start Date: </label>
            <input type="datetime" id="startDate" value="<?php echo $model->getStartDate(); ?>" name="startDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="endDate">End Date: </label>
            <input type="datetime" id="endDate" value="<?php echo $model->getEndDate(); ?>" name="endDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="venue">Venue: </label>
            <select id="venue" name="venueId" class="form-control" >
                <?php foreach($this->getViewBag()['venues'] as $venue) : ?>
                    <option value="<?php echo $venue->getId() ?>"
                            <?php if(intval($venue->getId()) == $model->getVenueId())
                            echo 'selected="true"' ?>class=form-control">
                        <?php echo $venue->getName() ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <input type="submit" class="btn btn-default" value="Edit" />
    </form>
</div>