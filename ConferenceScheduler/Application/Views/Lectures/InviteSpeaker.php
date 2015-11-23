<?php /** @model = AddSpeakerBindingModel */?>
<div class="col-md-3 col-lg-offset-4" style="margin-bottom: 330px; margin-right: 800px;">
    <h2>Invite a speaker</h2>
    <div>
        <form method="post" action="/Lecture/<?php echo $model->getLectureId() ?>/Invite/Speaker">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" class="form-control"/>
            </div>

            <input type="submit" value="Add" class="btn btn-default">
        </form>
    </div>
</div>