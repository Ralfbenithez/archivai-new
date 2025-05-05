// Configuration de Toastr
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000"
};

// Filtrer les documents par type
function filterDocs(type) {
    // Mettre à jour les boutons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
    
    // Filtrer les éléments
    const items = document.querySelectorAll('#docBody .doc-item');
    items.forEach(item => {
        if (type === 'Tous' || item.getAttribute('data-type') === type) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

// Visualiser un document
function viewDocument(id) {
    // Afficher le modal de chargement
    $('#loadingModal').modal('show');
    
    // Simuler le chargement (à remplacer par une vraie requête AJAX)
    setTimeout(() => {
        $('#loadingModal').modal('hide');
        
        // Charger les détails du document (à remplacer par les vraies données)
        $('#viewModalTitle').text('Document #' + id);
        $('#viewModalBody').html(`
            <div class="text-center">
                <img src="api/document-preview.php?id=${id}" class="img-fluid mb-3" style="max-height: 400px;" alt="Aperçu du document">
                <div class="document-details">
                    <p><strong>Titre:</strong> Document ${id}</p>
                    <p><strong>Description:</strong> Description du document ${id}</p>
                    <p><strong>Date:</strong> 15/04/2025</p>
                    <p><strong>Type:</strong> Facture</p>
                </div>
            </div>
        `);
        
        $('#viewModal').modal('show');
    }, 800);
}

// Modifier un document
function editDocument(id) {
    toastr.info('Fonctionnalité de modification en cours de développement');
}

// Supprimer un document
function deleteDocument(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        // Ici, ajoutez votre code pour supprimer le document via AJAX
        toastr.success('Document supprimé avec succès');
        
        // Simuler la suppression de la ligne
        setTimeout(() => {
            const row = document.querySelector(`#docBody .doc-item[data-id="${id}"]`);
            if (row) row.remove();
        }, 500);
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Si on a un message de succès dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        toastr.success('Opération réalisée avec succès !');
    }
    
    // Si on a un message d'erreur dans l'URL
    if (urlParams.has('error')) {
        toastr.error('Une erreur est survenue.');
    }

    // Initialisation du graphique Doughnut
    const ctx = document.getElementById('doughnutChart').getContext('2d');
    const doughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Facture', 'Carte d\'identité', 'Extrait de naissance'],
            datasets: [{
                data: [50, 35, 15],
                backgroundColor: ['#e53935', '#1e88e5', '#43a047'],
                hoverBackgroundColor: ['#d32f2f', '#1976d2', '#388e3c']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});