<?php /** @model = ConferenceViewModel */?>
<div  style="padding: 30px; margin-left: 7%;" class="col-lg-12">
    <h1 style="margin-bottom: 3%;">Latest Conferences: </h1>
    <?php foreach($model as $conference): ?>
        <div class="thumbnail col-lg-3" style="background: #333; padding: 10px; margin-right: 20px;">
            <h3 style="color: #00bc8c">Title: <?php echo $conference->getTitle()?></h3>
            <h4>Owner: <?php echo $conference->getOwner()?></h4>
            <h4>Venue: <?php echo $conference->getVenue()?></h4>
            <p>Start Date: <?php echo $conference->getStartDate()?></p>
            <p>End Date: <?php echo $conference->getEndDate()?></p>
            <a href="/Conference/<?php echo $conference->getId() ?>/Details" class="btn btn-info btn-sm">Details</a>
        </div>
    <?php endforeach ?>
</div>