{{-- 
    Script centralizado para gestionar alertas y confirmaciones en todo el proyecto utilizando SweetAlert2, 
    basado en diferentes casos de uso para ciudadanos y ciudades.
--}}
@push('scripts')
<script>
// Toast genérico
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    theme: 'auto',
    didOpen: t => {
        t.addEventListener('mouseenter', Swal.stopTimer);
        t.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// Toast de éxito al crear/editar ciudades/ciudadanos
@if(session('success'))
    Toast.fire({
        icon: 'success',
        title: {!! json_encode(session('success')) !!}
    });
@endif

// Toast de éxito al eliminar ciudades/ciudadanos
@if(session('deleted'))
    Toast.fire({
        icon: 'success',
        title: {!! json_encode(session('deleted')) !!}
    });
@endif

// Modal de confirmación de eliminación de ciudadano
document.querySelectorAll('.btn-delete-citizen').forEach(btn =>
    btn.addEventListener('click', e => {
        e.preventDefault();
        const form = btn.closest('form');
        Swal.fire({
            theme: 'auto',
            icon: 'warning',
            title: '¿Eliminar este ciudadano?',
            text: '¡No podrás deshacer esta acción!',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc2626'
        }).then(res => res.isConfirmed && form.submit());
    })
);

// Modal de confirmación de eliminación de ciudad
document.querySelectorAll('.btn-delete-city').forEach(btn =>
    btn.addEventListener('click', e => {
        e.preventDefault();
        const form = btn.closest('form');
        const has = parseInt(btn.dataset.hasCitizens, 10);
        if (has > 0) {
            Swal.fire({
                theme: 'auto',
                icon: 'error',
                title: '¡No se puede eliminar!',
                text: 'La ciudad tiene ciudadanos.',
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#dc2626'
            });
        } else {
            Swal.fire({
                theme: 'auto',
                icon: 'warning',
                title: '¿Eliminar ciudad?',
                text: '¡No podrás deshacer esta acción!',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc2626',
            }).then(res => res.isConfirmed && form.submit());
        }
    })
);
</script>
@endpush
