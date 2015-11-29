<?php /** @model = DetailedConferenceViewModel */?>
<div class="col-md-12">
    <div class="col-lg-offset-5">
        <h2 style="color: #00bc8c">Title: <?php echo $model->getTitle()?></h2>
        <h4>Owner: <?php echo $model->getOwner()?></h4>
        <h4>Venue: <?php echo $model->getVenue()?></h4>
        <p>Start Date: <?php echo $model->getStartDate()?></p>
        <p>End Date: <?php echo $model->getEndDate()?></p>
    </div>
    <div class="col-lg-offset-2">
        <?php if(count($model->getLectures()) > 0) : ?>
            <div class="col-lg-12">
                <h4>Lectures:</h4>
                <?php foreach ($model->getLectures() as $lecture) : ?>
                    <div class="thumbnail col-lg-3" style="background: #333; padding: 10px; margin-right: 20px;">
                        <h3 style="color: #00bc8c">Title: <?php echo $lecture->getName()?></h3>
                        <p>Start Date: <?php echo $lecture->getStartDate()?></p>
                        <p>End Date: <?php echo $lecture->getEndDate()?></p>
                        <p><u>Hall: <?php echo $lecture->getHall()->getHallName() ?></u></p>
                        <p>Places: (<?php echo $lecture->getLectureJoinedMembers() ?> / <?php echo $lecture->getHall()->getMaxHallPlaces() ?>) </p>
                        <?php if($lecture->getSpeakers()) : ?>
                            <div>
                                <h4>Speakers: </h4>
                                <?php foreach($lecture->getSpeakers() as $speaker): ?>
                                    <p><?php echo $speaker->getUsername() ?></p>
                                <?php endforeach; ?>
                            </div>

                        <?php else : ?>
                            <h4 style="color: #ff0000;">No speakers are assigned yet!</h4>
                        <?php endif; ?>

                        <?php
                        $hasVisited = false;
                        $lectureId = $lecture->getId();
                        foreach ($this->getViewBag()['visits'] as $visit) {
                            if(intval($visit->getLectureId()) === intval($lecture->getId())){
                                $hasVisited = true;
                            }
                        }
                        if($hasVisited){
                            echo "<a href='/Lecture/$lectureId/NotVisit' class=\"btn btn-danger btn-xs\">Not Visit</a>";
                        }
                        else{
                            echo "<a href='/Lecture/$lectureId/Visit' class=\"btn btn-success btn-xs\">Must Visit</a>";
                        }
                        ?>

                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-offset-4" style="margin-bottom: 30px;">
                <h3>Best Sequence:</h3>
                <div>
                    <?php foreach ($this->getViewBag()['sequence'] as $lecture ) : ?>
                        <p><?php echo $lecture->getName() ?></p>
                    <?php endforeach ?>
                </div>

                <a href='/Conference/<?php echo $model->getId()?>/Apply' class="btn btn-success btn-sm">Apply</a>

            </div>
        <?php else : ?>
            <h4 style="color:red; margin-bottom: 320px;">No Lectures available at this moment!</h4>
        <?php endif; ?>
    </div>
    <hr>
</div>