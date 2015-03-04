<h3>Voici les News du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

<div class="col-md-offset-2 col-md-8" style="margin-top:2%;">

	<div id="goBack" >
	</div>
	
	<div id="optionNews">
	</div>

	<div id="divNewspapers" >
	</div>

	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- --------------------------------------------  Modals Update Newspaper ---------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="updateNewspaperModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier une sous-éspèce</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="alterResume">quick description :</label>
							<div class="controls">
								<textarea name="alterResume" id="alterResume" rows="10" cols="70">
								</textarea>
							</div>
						</div>
					</form>
				</div><!-- /.modal-body -->

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesNewspaper">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- --------------------------------------------  Modals Insert Newspaper ---------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<div id="addNewspaperModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier une sous-éspèce</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="insertResume">Résumé :</label>
							<div class="controls">
								<textarea type="datetime" name="insertResume" id="insertResume" rows="10" cols="70">
								</textarea>
							</div>
						</div>
					</form>
				</div><!-- /.modal-body --> 
				
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnCreateNewspaper">Create Newspaper</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	
</div>