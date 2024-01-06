<?php

$eventData = json_decode(file_get_contents('events.json'), true);

$days      = $eventData['days'];
$rooms     = $eventData['rooms'];
$maxRoomID = max(array_keys($rooms));
$levels    = $eventData['levels'];
$events    = $eventData['events'];

$timeStart = 24;
$timeEnd   = 0;
$events    = array_map(function ($event) {
    global $timeStart, $timeEnd;
    $event['day'] = str_replace('.', '-', $event['day']);
//    if (!is_array($event['teachers'])) {
//        $event['teachers'] = explode(',', $event['teachers']);
//    }
//    $event['teachersStr'] = implode(', ', $event['teachers']);
    $event['teachersStr'] = $event['teachers'];
    $event['teachers']    = array($event['teachers']);

    $hour = (int)explode(':', $event['hour'])[0];
    if ($hour < $timeStart) {
        $timeStart = $hour;
    }

    $hour = (int)explode(':', $event['hourEnd'])[0];
    if ($hour > $timeEnd) {
        $timeEnd = $hour;
    }
    return $event;
}, $events);

$teachers = array_reduce($events, function ($acc, $event) {
    foreach ($event['teachers'] as $teacher) {
        if (!empty($teacher) && !in_array($teacher, $acc)) {
            $acc[] = $teacher;
        }
    }
    return $acc;
}, []);

$dances = array_reduce($events, function ($acc, $event) {
    if (!empty($event['dance']) && !in_array($event['dance'], $acc)) {
        $acc[] = $event['dance'];
    }
    return $acc;
}, []);

sort($teachers);
sort($dances);

$eventId = 0;
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $eventData["title"]; ?></title>
    <meta charset="UTF-8">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css"
          integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <style>
        /*custom level from json*/
        <?php foreach ($levels as $level): ?>

        .level_<?= $level["id"]; ?> a {
        <?php foreach ($level["style"] as $row): ?>
        <?= trim($row, " ;") ?> !important;
        <?php endforeach; ?>
        }

        <?php endforeach; ?>
    </style>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.min.js"
            integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>document.getElementsByTagName("html")[0].className += " js";</script>


</head>
<body>
<header>
    <h3><?= $eventData["title"]; ?></h3>
    <p>Esemény: <a href="<?= $eventData["url"]; ?>" target="_blank"><?= $eventData["url"]; ?></a></p>

    <div class="row col-12">
        <!--        <div class="row col-8">-->
        <!--            <ul class="item-picker">-->
        <!--                --><?php //foreach ($teachers as $teacher): ?>
        <!--                    <li>-->
        <!--                        <div class="form-check">-->
        <!--                            <input class="form-check-input lessonToggle lessonToggleTeacher " type="checkbox" checked id="teacher_--><?php //= $teacher ?><!--">-->
        <!--                            <label class="form-check-label" for="day_--><?php //= $teacher ?><!--">--><?php //= $teacher ?><!--</label>-->
        <!--                        </div>-->
        <!--                    </li>-->
        <!--                --><?php //endforeach; ?>
        <!--            </ul>-->
        <!--        </div>-->

        <div class="row col-7">
            <ul class="item-picker">
                <?php foreach ($dances as $dance): ?>
                    <li>
                        <div class="form-check form-switch">
                            <input class="form-check-input lessonToggle" type="checkbox" checked id="dance_<?= $dance ?>">
                            <label class="form-check-label" for="dance_<?= $dance ?>"><?= strtoupper($dance) ?></label>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="row col-5">
            <ul class="item-picker">
                <?php foreach ($days as $day): ?>
                    <li>
                        <div class="form-check form-switch">
                            <input class="form-check-input lessonToggleDay" type="checkbox" checked id="day_<?= $day ?>">
                            <label class="form-check-label" for="day_<?= $day ?>"><?= $day ?></label>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="row col-12">
            <ul class="item-picker">
                <?php foreach ($levels as $level): ?>
                    <li>
                        <div class="form-check form-switch">
                            <input class="form-check-input lessonToggle " type="checkbox" checked id="level_<?= $level['id'] ?>">
                            <label class="form-check-label" for="level_<?= $level['id'] ?>" title="<?= $level['title'] ?>: <?= $level['info']; ?>"><?= $level['title'] ?></label>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</header>

<div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
    <div class="cd-schedule__timeline">
        <ul>
            <?php for ($i = $timeStart; $i < $timeEnd; $i++): ?>
                <li><span><?= sprintf("%02s", $i) ?>:00</span></li>
            <?php endfor; ?>
        </ul>
    </div> <!-- .cd-schedule__timeline -->

    <div class="cd-schedule__events">
        <ul id="schedule__events">
            <?php foreach ($days as $day): ?>
                <?php foreach ($rooms as $roomID => $room): ?>
                    <li class="cd-schedule__group day_<?= $day; ?> <?= ($roomID == $maxRoomID) ? 'dayEnd' : '' ?>">
                        <div class="cd-schedule__top-info text-center">
                            <span><?= $day ?><br><?= $room["title"] ?></span>
                        </div>
                        <ul>
                            <?php foreach ($events as $event): ?>
                                <?php if ($event['day'] == $day && (int)$event['room'] == ($room["id"])):
                                    $eventId++;
                                    $teacherStr = implode(' ', array_map(function ($teacher) {
                                        return 'teacher_' . $teacher;
                                    }, $event['teachers']));
                                    ?>
                                    <li class="cd-schedule__event level_<?= $event["level"] ?> dance_<?= $event["dance"] ?>" data-level="<?= $event["level"] ?>" data-dance="<?= $event["dance"] ?>"
                                        id="event_<?= $eventId; ?>">
                                        <a data-start="<?= $event['hour'] ?>" data-end="<?= $event['hourEnd'] ?>" data-event="event-2">
                                            <div class="cd-schedule__name">
                                                <div class="title"><?= $event['title'] ?></div>
                                                <div class="teachers"><?= $event["teachersStr"] ?></div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endif;
                            endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="cd-schedule-modal">
        <header class="cd-schedule-modal__header">
            <div class="cd-schedule-modal__content">
                <span class="cd-schedule-modal__date"></span>
                <h3 class="cd-schedule-modal__name"></h3>
            </div>

            <div class="cd-schedule-modal__header-bg"></div>
        </header>

        <div class="cd-schedule-modal__body">
            <div class="cd-schedule-modal__event-info"></div>
            <div class="cd-schedule-modal__body-bg"></div>
        </div>

        <a class="cd-schedule-modal__close text-replace" href="#0">Close</a>
    </div>

    <div class="cd-schedule__cover-layer"></div>
</div>

<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<script>

    $(".lessonToggle").click(function () {
        const events = $('.cd-schedule__event');

        for (const event of events) {
            let eventOBJ = $("li#" + event.id);
            const level = eventOBJ.data('level');
            const dance = eventOBJ.data('dance');
            const day = eventOBJ.data('day');
            const teacher = eventOBJ.data('teacher');

            if ($('#level_' + level).is(':checked') && $('#dance_' + dance).is(':checked')) {
                // && $('#day_' + day).is(':checked') && $('#teacher_' + teacher).is(':checked')
                eventOBJ.show();
            } else {
                eventOBJ.hide();
            }
        }
    });


    $(".lessonToggleDay").on('click', function () {
        if ($(this).is(':checked')) {
            $('.' + $(this).attr('id')).show();
        } else {
            $('.' + $(this).attr('id')).hide();
        }
    });

</script>
</body>

</html>
