<ul class="nav table-nav">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
        Action <span class="caret"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
  
        <li role="presentation">
          <a data-toggle="modal" href="#{{ $id}}restore_pro">
            <i class="fa fa-refresh" aria-hidden="true"></i>{{__("Restore")}}
          </a>
        </li>

        <li role="presentation" class="divider"></li>

        <li role="presentation">
          <a data-toggle="modal" href="#{{ $id}}pro">
            <i class="fa fa-trash-o" aria-hidden="true"></i> {{__("Delete")}}
          </a>
        </li>

      </ul>
    </li>
  </ul>

<div id="{{ $id }}restore_pro" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to restore this product <b>{{ $name[app()->getLocale()] ?? $name[config('translatable.fallback_locale')] }}</b>? This process cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <form method="post" action="{{route('restore.variant.products',$id)}}" class="pull-right">
                {{csrf_field()}}
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-md bg-green">Yes</button>
            </form>
        </div>
        </div>
    </div>
</div>
  
<div id="{{ $id }}pro" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">Are You Sure ?</h4>
          <p>Do you really want to delete this product <b>{{ $name[app()->getLocale()] ?? $name[config('translatable.fallback_locale')] }}</b>? This process cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <form method="post" action="{{route('force.trash.variant.products',$id)}}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-danger">Yes</button>
          </form>
        </div>
      </div>
    </div>
</div>