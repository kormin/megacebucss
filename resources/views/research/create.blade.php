@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Exhibit Research</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('research/store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>                        
                        </div>

                        <div class="form-group{{ $errors->has('research_abstract') ? ' has-error' : '' }}">
                            <label for="research-abstract" class="col-md-4 control-label">Research Abstract</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="3" id="research_abstract" name="research_abstract" value="{{ old('research_abstract') }}"></textarea>

                                @if ($errors->has('research_abstract'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('research_abstract') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>             

                        <div class="form-group{{ $errors->has('document_file_name') ? ' has-error' : '' }}">
                            <label for="document-file-name" class="col-md-4 control-label">File</label>

                            <div class="col-md-6">
                                <input type="file" id="document-file-name" name="document_file_name">
                                @if ($errors->has('document_file_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('document_file_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Exhibit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
