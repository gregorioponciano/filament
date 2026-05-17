<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if (session('sucesso'))
        Swal.fire({ icon: 'success', title: 'Sucesso!', text: '{{ session('sucesso') }}', confirmButtonColor: '#2563eb', timer: 3000, timerProgressBar: true });
    @endif
    @if (session('erro'))
        Swal.fire({ icon: 'error', title: 'Erro!', text: '{{ session('erro') }}', confirmButtonColor: '#dc2626' });
    @endif
    @if (session('aviso'))
        Swal.fire({ icon: 'warning', title: 'Aviso!', text: '{{ session('aviso') }}', confirmButtonColor: '#ca8a04' });
    @endif
    @if (session('success'))
        Swal.fire({ icon: 'success', title: 'Sucesso!', text: '{{ session('success') }}', confirmButtonColor: '#2563eb', timer: 3000, timerProgressBar: true });
    @endif
    @if (session('error'))
        Swal.fire({ icon: 'error', title: 'Erro!', text: '{{ session('error') }}', confirmButtonColor: '#dc2626' });
    @endif
    @if (session('suporte'))
        Swal.fire({ icon: 'success', title: 'Chamado enviado!', text: '{{ session('suporte') }}', confirmButtonColor: '#2563eb', timer: 3000, timerProgressBar: true });
    @endif
});
</script>
