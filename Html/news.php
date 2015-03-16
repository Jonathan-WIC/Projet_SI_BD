<h3>Voici les News du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

<div class="col-md-offset-2 col-md-8" style="margin-top:2%;">

	<div id="goBack" >
	</div>
	
	<div class="tableOption" id="optionNews">
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
					<h4 class="modal-title">Modifier un journal</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="alterResume">quick description* :</label>
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
					<h4 class="modal-title">Ajouter un journal</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal" id="formCreateNewspaper">
						<div class="control-group">
							<label class="control-label" for="insertResume">quick description* :</label>
							<div class="controls">
								<textarea name="insertResume" id="insertResume" rows="10" cols="70">
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


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ----------------------------------------------  Modals Update News  ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<div id="updateNewsModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un Article</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal" id="formUpdateNews" method="post" enctype="multipart/form-data">
						<div class="control-group">
							<input type="hidden" id="roleUpdateNews" name="role" value="updateNews">
							<input type="hidden" id="recupNewsId" name="recupNewsId">
							<label class="control-label" for="updateTitle">Title* :</label>
							<div class="controls">
								<input type="text" id="updateTitle" name="updateTitle">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="updateContent">Contenu* :</label>
							<div class="controls">
								<textarea name="updateContent" id="updateContent" rows="10" cols="70">
								</textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="updateImage">Image :</label>
							<div class="controls">
								<input type="file" name="updateImage" id="updateImage" accept="image/*">
							</div>
						</div>
					</form>
				</div><!-- /.modal-body --> 
				
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSaveChangesNews">Saves changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- ------------------------------------------------------------------------------------------------------------------ -->
	<!-- --------------------------------------------  Modals Insert News  ------------------------------------------------ -->
	<!-- ------------------------------------------------------------------------------------------------------------------ -->


	<div id="addNewsModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un article</h4>
				</div>

				<div class="modal-body">
                    <form class="form-horizontal" id="formCreateNews" method="post" enctype="multipart/form-data">
						<div class="control-group">
							<input type="hidden" id="roleCreateNews" name="role" value="createNews">
							<input type="hidden" id="recupNewspaperId" name="recupNewspaperId">
							<label class="control-label" for="addTitle">Title* :</label>
							<div class="controls">
								<input type="text" id="addTitle" name="addTitle">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addContent">Contenu* :</label>
							<div class="controls">
								<textarea name="addContent" id="addContent" rows="10" cols="70">
								</textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addImage">Image :</label>
							<div class="controls">
								<input type="file" name="addImage" id="addImage" accept="image/*">
							</div>
						</div>
					</form>
				</div><!-- /.modal-body --> 

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnCreateNews">Create Article</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<?php 
		if($_SESSION['model'] != 'MDBase_editorialiste')
			echo '<input type="hidden" value="0" />';
		else
			echo '<input type="hidden" id="valMD" value="1" />';
	?>


</div>