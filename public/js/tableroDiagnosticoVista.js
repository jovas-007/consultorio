window.onload = function () {
  const archivos = document.getElementById('archivos')
  archivos.addEventListener('change', (event) => {
    const target = event.target;
    if (target.files && target.files[0]) {
      const limite = 40 * 1024 * 1024;
      for (i=0; i< target.files.length; i++) {
        if (target.files[i].size > limite) {
          alert("El archivo "+target.files[i].name+" sobrepasa el máximo de tamaño 40MB");
          target.value = null;
        }
      }
    }
  });
}