<?php

$days  = $event["days"];
$rooms = $event["rooms"];

?>
<div class="card">
	<div class="card-header" id="eventTitle">
		<h5 class="mb-0">
			Alapadatok
		</h5>
	</div>
	<div class="card-body">
		<form method="post" action="" class="mt-2" enctype="multipart/form-data">
			<div class="form-group">
				<label for="name">Esemény neve</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Esemény neve" value="<?= $event["title"] ?>" required>
			</div>
			<div class="form-group">
				<label for="url">Esemény URL</label>
				<input type="url" class="form-control" id="url" name="url" placeholder="Esemény URL" value="<?= $event["url"] ?>" required>
			</div>

			<div class="form-group">
				<label for="rooms">Termek:</label>
				<div class="row col-12">
					<?php foreach ($event["rooms"] as $room): ?>
						<div class="col-12 row">
							<div class="col-2">
								<?= $room["id"]; ?>
							</div>
							<div class="col-10">
								<input type="text" class="form-control" name="rooms[<?= $room["id"]; ?>]" value="<?= $room["title"] ?>" required>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="form-group">
				<label for="rooms">Szintek:</label>
				<div class="row">
					<?php foreach ($event["levels"] as $id => $level): ?>
						<div class="col-12 row border-bottom pb-2">
							<div class="row">
								<label for="levels_name" class="col-4">Név:</label>
								<div class="col-8">
									<input type="text" class="form-control" name="levels_name[<?= $id; ?>]" value="<?= $level["title"] ?>" required>
								</div>
							</div>

							<div class="col-4">
								<label for="levels_class">ID:</label>
								<input type="number" class="form-control" name="levels_id[<?= $id; ?>]" value="<?= $level["id"] ?>" required>
							</div>
							<div class="col-8">
								<label for="levels_class">Leírás:</label>
								<input type="text" class="form-control" name="levels_info[<?= $id; ?>]" value="<?= $level["info"] ?>" required>
							</div>

							<div class="col-4">
								<label for="levels_class">Megjelenés:</label>
								<div style="<?= implode("; ", $level["style"]); ?>" class="m-2 p-1"> <?= $level["title"]; ?> </div>
							</div>
							<div class="col-8">
								<?php
								$style = "";
								foreach ($level["style"] as $value) {
									$style .= trim($value,"\n;").";\n";
								}
								?>
								<textarea class="form-control" rows="3" name="levels_style[<?= $id ?>]"><?= $style ?></textarea>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<button type="submit" name="update" value="basic" class="btn btn-primary">Mentés</button>
		</form>
	</div>
</div>

<!-- event edit Modal -->
<div class="modal"

