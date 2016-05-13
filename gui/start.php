<?php 
use php\app\init\{ChladnickaSettings, ScriptLoader};
 
use php\helpers\{Html, Url};?>

<div class="welcome-text text-center">
	<div>Chladnička Engine</div>
</div>

<?= ChladnickaSettings::engine()->loadContent(); ?>