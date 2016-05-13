<?php 
use app\init\{ChladnickaSettings, ScriptLoader};
 
use helpers\{Html, Url};?>

<div class="welcome-text text-center">
	<div>Chladnička Engine</div>
</div>

<?= ChladnickaSettings::engine()->loadContent(); ?>