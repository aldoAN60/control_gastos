// messageStore.js
import { ref } from 'vue';

const mensaje = ref('hola');
const mensaje_visible = ref(false);
const severity = ref('info');
const messageKey = ref(0);  // Clave única para controlar el renderizado del mensaje

// Función para actualizar el mensaje
function mostrarMensaje(nuevoMensaje, tipoSeverity) {
  mensaje.value = nuevoMensaje;
  severity.value = tipoSeverity;
  
  // Reiniciar mensaje visible antes de mostrar uno nuevo
  mensaje_visible.value = false;
  setTimeout(() => {
    mensaje_visible.value = true;
    messageKey.value += 1;  // Actualiza la key para forzar el renderizado
  }, 50);
}

// Exporta las variables y la función para usarlas globalmente
export default {
  mensaje,
  mensaje_visible,
  severity,
  messageKey,
  mostrarMensaje
};
