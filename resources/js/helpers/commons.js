// commons.js
function formatDate(dateString) {
    if (!dateString) {
        return "Fecha no válida";
    }
  
    try {
        const date = new Date(dateString);
        return date.toLocaleString("es-MX", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            timeZone: "America/Mexico_City",
        });
    } catch (error) {
        console.error("Error al formatear la fecha:", error);
        return "Fecha no válida";
    }
}

export default formatDate;