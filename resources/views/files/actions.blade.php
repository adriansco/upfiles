<div class="text-center">
    {{-- Validación del target --}}
    <a class="btn btn-primary
     ml-1" href="/storage/{{ $path }}"
        target="{{ $path === '#' ? '' : 'blank_' }}"><i class="fa fa-eye"></i></a>
    {{-- <a href="{{ route('documents.fetch', ['id' => $id]) }}" class="btn btn-info ml-1"><i class="fa fa-edit"></i></a> --}}
    {{-- Eliminar (Falta validar permisos mediante js) --}}
    <button id="test" class="btn btn-danger ml-1 destroybtn" type="button" value="{{ $id }}"><i
            class="fa fa-trash"></i></button>
</div>
