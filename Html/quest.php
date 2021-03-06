<?php 
	global $page;
?>
<h3>Here are Quests from the game</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-3 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="searchNameQuest">Name :</label>
				<div class="controls">
					<input type="text" id="searchNameQuest" name="searchNameQuest">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchStartDateQuest">begin after this date :</label>
				<div class="controls">
					<input type="datetime" id="searchStartDateQuest" name="searchStartDateQuest">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchDurationQuest">Duration :</label>
				<div class="controls">
					<input type="number" id="searchDurationQuest" name="searchDurationQuest">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchMinFeeQuest">Minimal Fee :</label>
				<div class="controls">
					<input type="number" id="searchMinFeeQuest" name="searchMinFeeQuest">
				</div>
			</div>
			<div>
				<button class="btn" id="btnQuestSearch" onclick="fillQuestTable(0)">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-6" style="margin-top:2%;">

	<div class="tableOption" id="optionQuest">
	</div>

	<div class="loaderTable divLoader"></div>

	<table id="tableQuests" class="table table-bordered">
		<thead>
			<tr id="theadQuests">
				<th>Id</th>
				<th>Name</th>
				<th>Starting date</th>
				<th>Duration</th>
				<th>Fee</th>
				<th>Reward</th>
				<?php
					if($_SESSION['model'] != 'MDBase_client'){
						echo '<th>Actions</th>';
						echo '<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>';

					}
				?>
			</tr>
		</thead>
		<tbody id="bodyTableQuests">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- ------------------------------------------------------------------------------------------------------------------ -->
	<!-- ---------------------------------------------  Modals Update Quest  ---------------------------------------------- -->
	<!-- ------------------------------------------------------------------------------------------------------------------ -->


	<div id="updateQuestModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-Title">Modifier une Quête</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal" id="formUpdateQuest">
						<div class="control-group">
							<label class="control-label" for="updateName">Name :</label>
							<div class="controls">
								<input type="text" id="updateName" name="updateName">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="updateStartingDate">Starting Date :</label>
							<div class="controls">
								<input type="date" name="updateStartingDate" id="updateStartingDate">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="updateDuration">Duration :</label>
							<div class="controls">
								<input type="number" name="updateDuration" id="updateDuration">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="updateFee">Fee :</label>
							<div class="controls">
								<input type="number" name="updateFee" id="updateFee">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectUpdateReward1">Rewarded Item N°1 :</label>
							<div class="controls">
								<select name="selectUpdateReward1" id="selectUpdateReward1" class="selectItem"></select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectUpdateReward2">Rewarded Item N°2 :</label>
							<div class="controls">
								<select name="selectUpdateReward2" id="selectUpdateReward2" class="selectItem"></select>
							</div>
						</div>
					</form>
				</div><!-- /.modal-body --> 
				
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSaveChangesQuest">Saves changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- ------------------------------------------------------------------------------------------------------------------ -->
	<!-- --------------------------------------------  Modals Insert Quest  ------------------------------------------------ -->
	<!-- ------------------------------------------------------------------------------------------------------------------ -->


	<div id="addQuestModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-Title">Ajouter une Quête</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal" id="formCreateQuest">
						<div class="control-group">
							<label class="control-label" for="addName">Name* :</label>
							<div class="controls">
								<input type="text" id="addName" name="addeName">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addStartingDate">Starting Date* :</label>
							<div class="controls">
								<input type="date" name="addStartingDate" id="addStartingDate" placeholder="yyyy-mm-dd">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addDuration">Duration* :</label>
							<div class="controls">
								<input type="number" name="addDuration" id="addDuration">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addFee">Fee* :</label>
							<div class="controls">
								<input type="number" name="addFee" id="addFee">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectInsertReward1">Rewarded Item N°1 :</label>
							<div class="controls">
								<select name="selectInsertReward1" id="selectInsertReward1" class="selectItem"></select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectInsertReward2">Rewarded Item N°2 :</label>
							<div class="controls">
								<select name="selectInsertReward2" id="selectInsertReward2" class="selectItem"></select>
							</div>
						</div>
					</form>
				</div><!-- /.modal-body --> 

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnCreateQuest">Create Quest</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php 
		if($_SESSION['model'] != 'MDBase_adminquest')
			echo '<input type="hidden" value="0" />';
		else
			echo '<input type="hidden" id="valMD" value="1" />';
	?>

</div>