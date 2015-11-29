<?php /** @model = ConferenceBindingModel */?>
<div class="col-lg-12 login">
    <h2 class="col-lg-offset-4">Create New Conference:</h2>
    <form method="post" action="/conference/create" class="col-lg-3 col-lg-offset-4">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="startDate">Start Date: </label>
            <input type="date" id="startDate" name="startDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="endDate">End Date: </label>
            <input type="date" id="endDate" name="endDate" class="form-control" />
        </div>

        <div class="form-group">
            <label for="venue">Venue: </label>
            <select id="venue" name="venueId" class="form-control" >
            <?php foreach($this->getViewBag()['venues'] as $venue) : ?>
                    <option value="<?php echo $venue->getId() ?>" class=form-control">
                        <?php echo $venue->getName() ?>
                    </option>
            <?php endforeach ?>
            </select>
        </div>

        <input type="submit" class="btn btn-default" value="Create" />
        <?php echo $this->getCsfrToken() ?>
    </form>
</div>