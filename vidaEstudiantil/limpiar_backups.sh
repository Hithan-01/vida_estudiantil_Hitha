#!/bin/bash
# Script para eliminar archivos de respaldo .bak

echo "════════════════════════════════════════════════"
echo "  Limpieza de Archivos de Respaldo (.bak)"
echo "════════════════════════════════════════════════"
echo ""

# Contar archivos .bak
COUNT=$(find . -name "*.bak" -type f | wc -l)

if [ "$COUNT" -eq 0 ]; then
    echo "✓ No hay archivos .bak para eliminar"
    exit 0
fi

echo "Se encontraron $COUNT archivos de respaldo:"
echo ""
find . -name "*.bak" -type f -exec ls -lh {} \; | awk '{print "  - " $9 " (" $5 ")"}'
echo ""
echo "════════════════════════════════════════════════"
echo ""
read -p "¿Deseas eliminarlos? (s/N): " respuesta

if [[ "$respuesta" =~ ^[Ss]$ ]]; then
    echo ""
    echo "Eliminando archivos .bak..."
    find . -name "*.bak" -type f -delete
    echo "✓ Archivos eliminados correctamente"
else
    echo ""
    echo "✗ Operación cancelada. Los archivos .bak se mantienen."
fi

echo ""
echo "════════════════════════════════════════════════"
