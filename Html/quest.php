<h3>Consulter les Quêtes du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-3 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="searchDateQuest">Date :</label>
				<div class="controls">
					<input type="datetime" id="searchDateQuest" name="searchDateQuest">
				</div>
			</div>
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="searchDurationQuest">Duration :</label>
				<div class="controls">
					<input type="number" id="searchDurationQuest" name="searchDurationQuest">
				</div>
			</div>
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="searchMinFeeQuest">Minimal Fee :</label>
				<div class="controls">
					<input type="number" id="searchMinFeeQuest" name="searchMinFeeQuest">
				</div>
			</div>
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="searchMaxFeeQuest">Date :</label>
				<div class="controls">
					<input type="number" id="searchMaxFeeQuest" name="searchMaxFeeQuest">
				</div>
			</div>
			<div>
				<button class="btn" id="btnQuestSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-5" style="margin-top:2%;">
	<table id="tableQuests" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Starting date</th>
				<th>Duration</th>
				<th>Fee</th>
			</tr>
		</thead>
		<tbody id="bodyTableQuests">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>

</div>