<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calendar</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css"
          integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.min.js"
            integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>document.getElementsByTagName("html")[0].className += " js";</script>
</head>

<?php

$rooms  = ['Eger', 'Park', 'Kisterem', 'Nagyterem'];
$days   = ['2024-01-19', '2024-01-20', '2024-01-21'];
$days   = ['2024-01-19', '2024-01-20'];
$levels = [[
    "title" => "Mindenki",
    "class" => "level-all"
], [
    "title" => "Tematikus",
    "class" => "level-tematic"
], [
    "title" => "Teljesen kezdő",
    "class" => "level-beginner"
], [
    "title" => "Kezdő 2023",
    "class" => "level-beginner2023"
], [
    "title" => "Középhaladó 2023",
    "class" => "level-intermediate2023"
], [
    "title" => "Középhaladó és Haladó",
    "class" => "level-intermediate-advanced"
], [
    "title" => "Haladó 2022",
    "class" => "level-advanced2022"
]];

$events =
    [
        [
            "day"      => "2024-01-19",
            "room"     => "Eger",
            "hour"     => "10:00",
            "hourEnd"  => "11:00",
            "title"    => "Meeting",
            "teachers" => ['Tomi', 'Sanyi'],
            "level"    => "level-all",
            "dance"     => "WestCoastSwing"
        ],
        [
            "day"      => "2024-01-19",
            "room"     => "Eger",
            "hour"     => "11:00",
            "hourEnd"  => "13:00",
            "title"    => "Meeting",
            "teachers" => ['Greg', 'Barbi'],
            "level"    => "level-intermediate2023",
            "dance"     => "Salsa"
        ]
    ];

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

<body>
<header>
    <div class="row col-12">
        <div class="row col-3">
            <ul>
                <?php foreach ($days as $day): ?>
                    <li>
                        <input type="checkbox" class="lessonToggle active" data-target="day_<?= $day ?>" checked>
                        <?= $day ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="row col-3">
            <ul>
                <?php foreach ($teachers as $teacher): ?>
                    <li>
                        <input type="checkbox" class="lessonToggle active" data-target="teacher_<?= $teacher ?>" checked>
                        <?= $teacher ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="row col-3">
            <ul>
            <?php foreach ($levels as $level): ?>
                <li>
                    <input type="checkbox" class="lessonToggle active" data-target="level_<?= $level['class'] ?>" checked>
                    <?= $level['title'] ?>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

        <div class="row col-3">
            <ul>
                <?php foreach ($dances as $dance): ?>
                    <li>
                        <input type="checkbox" class="lessonToggle active" data-target="dance_<?= $dance ?>" checked>
                        <?= $dance ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</header>

<div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
    <div class="cd-schedule__timeline">
        <ul>
            <?php for ($i = 8; $i < 24; $i++): ?>
                <li><span><?= sprintf("%02s", $i) ?>:00</span></li>
            <?php endfor; ?>
        </ul>
    </div> <!-- .cd-schedule__timeline -->

    <div class="cd-schedule__events">
        <ul>
            <?php foreach ($days as $day): ?>
                <?php foreach ($rooms as $room): ?>
                    <li class="cd-schedule__group day_<?= $day; ?>">
                        <div class="cd-schedule__top-info text-center"><span><?= $day ?><br><?= $room ?></span></div>

                        <ul>
                            <li class="cd-schedule__event">
                                <a data-start="09:00" data-end="10:00" data-content="event-rowing-workout" data-event="event-2" href="#0">
                                    <em class="cd-schedule__name">Rowing Workout</em>
                                </a>
                            </li>

                            <?php foreach ($events as $event): ?>
                                <?php if ($event['day'] == $day && $event['room'] == $room):
                                    $eventId++;
                                    $teacherStr = implode(' ', array_map(function ($teacher) {
                                        return 'teacher_' . $teacher;
                                    }, $event['teachers']));
                                    ?>
                                    <li class="cd-schedule__event level_<?= $event["level"] ?> <?= $teacherStr ?> dance_<?= $event["dance"] ?>">
                                        <a data-start="<?= $event['hour'] ?>" data-end="<?= $event['hourEnd'] ?>" data-content="bob" data-event="event-2" href="#0">
                                            <em class="cd-schedule__name"><?= $event['title'] ?></em>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>


    <div class="cd-schedule__cover-layer"></div>
</div>

<script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script>

    $(".lessonToggle").click(function () {
        if ($(this).is(':checked')) {
            $('.' + $(this).data('target')).show();
        } else {
            $('.' + $(this).data('target')).hide();
        }
    });

</script>
</body>

</html>
