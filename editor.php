
  		<div class="row">
  			<div class="col-lg-10">
  				<div class="panel panel-default">
  					<div class="panel-header" style="padding:15px;">
  						<a onclick="add_bold()" ><span class="glyphicon glyphicon-bold"></span></a> &nbsp;&nbsp;
						<a onclick="add_list()" ><span class="glyphicon glyphicon-th-list"></span></a> &nbsp;&nbsp;
  						<a onclick="add_italic()"><span class="glyphicon glyphicon-italic"></span></a> &nbsp;&nbsp;
  						<a data-target="#add_code" data-toggle="modal" id="code_snippet">
						<span style="font-size: 16px;font-weight: bold;">&lt;/&gt;</span></a>
						<a id="notification" class="alert alert-success collapse">code added</a>
  					</div>
  					<textarea id="textarea" class="form-control" placeholder="  write a reply" rows="8"></textarea>
					<button  id="comment_post" onclick="add_comment()" class="btn btn-primary
										pull-right" value="<?php echo $row['id']; ?>">Post</button>
					<button style='margin-right:5px;' id="preview" data-target="#preview_data" data-toggle="modal" 
					onclick="preview()" class="btn btn-default pull-right" type="submit">preview</button>
  				</div>
  			</div>
			<!-- preview of the text data -->
			<div class="modal " tabindex="-1" id="preview_data" data-backdrop="static">
    			<div class="modal-dialog modal-md">
        			<div class="modal-content">
        				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal">
			                    &times;
			                </button>
        					<h4 style="font-weight: bold;" class="modal-title">Preview</h4>
        				</div>
        				<div class="modal-body" data-spy="scroll">
        					<p id="text_code"> </p>
							<pre hidden id="code"> </pre>
        				</div>
        				<div class="modal-footer">
        					<button id="preview" class="btn btn-default pull-right" 
							data-dismiss='modal' type="submit">Okay</button>
        				</div>
        			</div>
        		</div>
        	</div>
			<!-- adding code snippet -->
  			<div class="modal " tabindex="-1" id="add_code" data-backdrop="static">
    			<div class="modal-dialog modal-md">
        			<div class="modal-content">
        				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal">
			                    &times;
			                </button>
        					<h4 style="font-weight: bold;" class="modal-title">Add a Code Snippet</h4>
        				</div>
        				<div class="modal-body" data-spy="scroll">
        					<textarea id="code_textarea" placeholder=" Write your code here.."
							class="form-control" rows="15"></textarea>
        				</div>
        				<div class="modal-footer">
        					<button onclick="add_code_btn()" id="add_code_btn" class="btn btn-default pull-right" 
							data-dismiss='modal' type="submit">Add</button>
        				</div>
        			</div>
        		</div>
        	</div>
  		</div>