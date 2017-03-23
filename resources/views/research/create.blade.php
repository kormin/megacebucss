@extends('layouts.general')

@section('title', 'Create Research')

@section('content')
<!-- FORM START -->
<div class="container">
	<div class="row">
    <div class="col s12 m12">
      <div class="card grey lighten-5">
        <div class="card-content black-text">
          <span class="card-title">Exhibit Research</span>
          <hr>
          <div class="row">
          	<form class="col s12" method="post" action="{{ url('research/store') }}" enctype="multipart/form-data">
          	{{ csrf_field() }}
          		<div class="row">
			        <div class="input-field col s6 {{ $errors->has('title') ? ' has-error' : '' }}">
			          <input id="post_title" type="text" class="validate" name="title" required>
			          <label for="post_title">Post Title</label>
			        </div>
			        <div class="input-field col s6">
			          <input id="post_author" type="text" class="validate" indigo darken-4>
			          <label for="post_author">Author</label>
			        </div>
		      	</div>
			    <div class="row">
			    	<div class="input-field col s12 {{ $errors->has('research_abstract') ? ' has-error' : '' }}">
			          <textarea id="post_content" class="materialize-textarea" name="research_abstract"></textarea>
			          <label for="post_content">Content</label>
		       		</div>
			    </div>
			    <div class="row">
			      	<div class="input-field col s12">
			         	<div class="chips chips-initial">
					    	Tags
					    	<i class="close material-icons">close</i>
					  	</div>
			          	<label for="post_tags">Tags</label>
			        </div>
			    </div>
			    <div class="row">
			      	<div class="file-field input-field {{ $errors->has('document_file_name') ? ' has-error' : '' }}">
				      <div class="btn">
				        <span>File</span>
				        <input type="file" name="document_file_name">
				      </div>
				      <div class="file-path-wrapper">
				        <input class="file-path validate" type="text" placeholder="Upload file">
				      </div>
				    </div>
			    </div>
          </div>
        </div>
        <div class="card-action">
            <button class="btn waves-effect waves-light blue darken-3" type="submit" name="action">Post
				<i class="material-icons right">send</i>
			</button>
			<!-- <a class="waves-effect waves-light btn blue darken-3"><i class="material-icons right">send</i>Post</a> -->
            <a class="waves-effect waves-light btn grey">Back</a>
        </div>
        </form>        
      </div>
    </div>
  </div>
  </div>
  <!-- FORM END -->
@endsection