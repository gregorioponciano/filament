
document.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('alert-sucesso');

    // 🔹 Aparecer crescendo
    setTimeout(() => {
        alert.classList.remove('scale-75', 'opacity-0');
        alert.classList.add('scale-100', 'opacity-100');
    }, 100);

    // 🔹 Sumir encolhendo depois de 3s
    setTimeout(() => {
        alert.classList.remove('scale-100', 'opacity-100');
        alert.classList.add('scale-75', 'opacity-0');

        // 🔹 Remover do DOM depois da animação
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 3000);
});
 
