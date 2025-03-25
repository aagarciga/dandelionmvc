<script async src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    const widgets = document.querySelectorAll('.widgets');
    
    new Sortable(widgets[0], {
        animation: 150
    })
</script>