document.addEventListener('DOMContentLoaded', function() {
    const syllabusData = document.getElementById('syllabus-data');
    if (!syllabusData) return;

    let currentPage = 1;
    const totalPages = Number(syllabusData.dataset.totalPages);
    const linesPerPage = Number(syllabusData.dataset.linesPerPage);
    const syllabusLines = JSON.parse(syllabusData.dataset.syllabus);
    const totalLines = Number(syllabusData.dataset.totalLines);

    window.changePage = function(change) {
        currentPage += change;
        let syllabusContent = document.getElementById('syllabus-content');
        if (!syllabusContent) return;

        syllabusContent.innerHTML = '';

        for (let i = (currentPage - 1) * linesPerPage; i < Math.min(currentPage * linesPerPage, totalLines); i++) {
            if (!syllabusLines[i]) continue;
            
            let p = document.createElement("p");
            p.textContent = syllabusLines[i];
            p.classList.add(i === (currentPage - 1) * linesPerPage ? "syllabus-first-line" : "syllabus-item");
            syllabusContent.appendChild(p);
        }

        const pageInfo = document.getElementById('page-info');
        if (pageInfo) {
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        }

        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPages;
    };

    // Initialize first page
    changePage(0);
});
