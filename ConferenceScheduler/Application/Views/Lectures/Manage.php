<?php /** @model = LectureViewModel */?>
<div  style="padding: 30px; margin-left: 7%;" class="col-lg-12">
    <h1 style="margin-bottom: 3%;">Conference Lectures: </h1>
    <?php foreach($model as $lecture): ?>
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
                        <p><?php echo $speaker ?></p>
                    <?php endforeach ?>
                </div>
            <?php else : ?>
                <h4 style="color: #ff0000;">No speakers are assigned yet!</h4>
            <?php endif; ?>
            <div>
                <h4></h4>
            </div>
        </div>
    <?php endforeach ?>
</div>
