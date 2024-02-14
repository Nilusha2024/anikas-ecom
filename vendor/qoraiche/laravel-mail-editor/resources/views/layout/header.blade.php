<header>
        <nav class="navbar text-light bg-primary header">
            <div class="container">
                <div class="d-flex align-items-center py-3 header">
                    <a href="{{url('/')}}" title="{{ $title }}"> <img height="50px"
                    src="{{url('images/genral/'.$front_logo)}}" alt="logo"> </a>
                    <h5 class="mb-0 ml-3">
                      <strong>{{ $title }}</strong>
                    </h5>
                </div>

                <div class="float-right">
                    <a role="button" href="{{ url()->previous() }}" class="btn btn-md btn-warning">
                       <i class="fas fa-arrow-left"></i> {{__("Back")}}
                    </a>
                </div>
                {{-- <div class="form-inline">
                    <div class="dropdown">

                      <span class="dropdown-toggle language-selector" tid="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                      </span>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Arabic</a>
                        <a class="dropdown-item active" href="#">English</a>
                        <a class="dropdown-item" href="#">Russian</a>
                      </div>
                    </div>
                </div> --}}
            </div>
        </nav>
    </header>