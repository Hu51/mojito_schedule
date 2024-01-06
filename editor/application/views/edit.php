<?php

$days   = $event["days"];
$rooms  = $event["rooms"];
$levels = $event["levels"];
$events = $event["events"];

?>
<style>
	/*custom level from json*/
	<?php foreach ($levels as $level): ?>

	.level_<?= $level["id"]; ?> {
	<?php foreach ($level["style"] as $row): ?> <?= trim($row, " ;") ?> !important;
	<?php endforeach; ?>
	}

	<?php endforeach; ?>
</style>

<table class="table table-bordered w-100">
	<thead>
	<tr>
		<td></td>
		<?php foreach ($days as $day): ?>
			<th colspan="<?= count($rooms) ?>" class="text-center"><?= $day; ?></th>
		<?php endforeach; ?>
	</tr>
	<tr>
		<th></th>
		<?php foreach ($days as $day): ?>
			<?php foreach ($rooms as $room): ?>
				<th><?= $room["title"]; ?></th>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</tr>
	</thead>
	<tbody>
	<?php for ($hour = 7; $hour < 24; $hour++): ?>
		<tr>
			<td><?= $hour; ?>:00</td>
			<?php foreach ($days as $day): ?>
				<?php foreach ($rooms as $room): ?>
					<td id="<?= $room["id"] ?>_<?= $day ?>_<?= $hour ?>">
						<?php

						$event     = array_filter($events, function ($e) use ($room, $day, $hour) {
							$evHour = intval(explode(":", $e["hour"])[0]);
							return $e["room"] == $room["id"] && $e["day"] == $day && $evHour == $hour;
						});

						if ($event):
							$id = array_keys($event)[0];
							$event = array_shift($event);
							?>
							<span class="editEvent btn w-100 p-1 level_<?= $event["level"]; ?>" data-id="<?= $id ?>" data-room="<?= $room["id"] ?>" data-day="<?= $day ?>"
								  data-hour="<?= $hour ?>">
								<?= $event["hour"] ?>-<?= $event["hourEnd"] ?><br>
								<?= $event["title"] ?><br>
								<?= $event["teachers"] ?>
							</span>

						<?php else : ?>
							<span class="addEvent btn w-100 btn-outline-success" data-room="<?= $room["id"] ?>" data-day="<?= $day ?>" data-hour="<?= $hour ?>">+</span>
						<?php endif; ?>
					</td>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</tr>
	<?php endfor; ?>
	</tbody>
</table>

<!-- event edit Modal -->
<div id="editEventModal" class="modal modal-lg">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" method="post" id="updateform">
				<div class="modal-header">
					<h4 class="modal-title">Esemény szerkesztése</h4>
					<button type="button" class="btn close closeEditModal" data-dismiss="modal">&times;</button>
				</div>

				<input type="hidden" name="room" id="editEventRoom">
				<input type="hidden" name="day" id="editEventDay">
				<input type="hidden" name="id" id="editEventId">

				<div class="modal-body">
					<div class="form-inline row">
						<label for="editEventHour" class="col-4">Időpont:</label>
						<div class="row col-4">
							<input type="time" class="form-control col-4" name="hour" id="editEventHour" required>
						</div>
						<div class="row col-4">
							<input type="time" class="form-control col-4" name="hourEnd" id="editEventHourEnd">
						</div>
					</div>
					<div class="form-group">
						<label for="editEventTitle">Cím:</label>
						<input type="text" class="form-control" name="title" id="editEventTitle" required>
					</div>

					<div class="form-group">
						<label for="editEventLevel">Szint:</label>
						<select name="level" id="editEventLevel" class="form-control">
							<?php foreach ($levels as $level): ?>
								<option value="<?= $level["id"] ?>"><?= $level["title"] ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="editEventTeachers">Tanárok:</label>
						<input type="text" class="form-control" name="teachers" id="editEventTeachers" required>
					</div>

					<div class="form-group">
						<label for="editEventDance">Tánc:</label>
						<input type="text" class="form-control" name="dance" id="editEventDance" required>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" name="action" value="update" class="btn btn-primary">Mentés</button>
					<button type="button" class="btn btn-warning closeEditModal" data-dismiss="modal">Bezárás</button>
					<button type="submit" id="deleteEvent" onclick="return confirm('Biztosan törölni szeretnéd?')" name="action" value="delete" class="btn btn-danger deleteEvent"
							data-dismiss="modal">
						Töröl
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>

	$(".closeEditModal").on("click", function () {
		$("#editEventModal").modal("hide");
	});

	$(".editEvent").on("click", function () {
		$("#editEventModal").find(".modal-title").html("Esemény szerkesztése");
		let id = $(this).data("id");
		fetch("<?= base_url(); ?>api/getEventData/?id=" + id)
			.then(response => response.json())
			.then(data => {
				console.log(data)
				$("#editEventModal").find("#editEventTitle").val(data.title);
				$("#editEventModal").find("#editEventTeachers").val(data.teachers);
				$("#editEventModal").find("#editEventDance").val(data.dance);
				$("#editEventModal").find("#editEventLevel").val(data.level);
				$("#editEventModal").find("#editEventHour").val(data.hour);
				$("#editEventModal").find("#editEventHourEnd").val(data.hourEnd);
				$("#editEventModal").find("#editEventRoom").val(data.room);
				$("#editEventModal").find("#editEventDay").val(data.day);
				$("#editEventModal").find("#editEventId").val(id);

				$("#editEventModal").find("#deleteEvent").show();
				$("#editEventModal").modal("show");
			});
	});

	$(".addEvent").on("click", function () {
		$("#editEventModal").find(".modal-title").html("Esemény felvétele");

		let hour = $(this).data("hour").toString().padStart(2, "0") + ":00";
		let hourEnd = ($(this).data("hour") + 1).toString().padStart(2, "0") + ":00";
		console.log(hourEnd, hour);

		$("#editEventModal").find("#editEventTitle").val('');
		$("#editEventModal").find("#editEventTeachers").val('');
		$("#editEventModal").find("#editEventDance").val('');
		$("#editEventModal").find("#editEventLevel").val('');
		$("#editEventModal").find("#editEventHour").val(hour);
		$("#editEventModal").find("#editEventHourEnd").val(hourEnd);
		$("#editEventModal").find("#editEventRoom").val($(this).data("room"));
		$("#editEventModal").find("#editEventDay").val($(this).data("day"));
		$("#editEventModal").find("#editEventId").val('new');

		$("#editEventModal").find("#deleteEvent").hide();
		$("#editEventModal").modal("show");
	});

</script>

