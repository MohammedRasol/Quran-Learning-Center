<div class="modal fade show" id="showLessonNotes" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header  alert alert-info">
                <h5 class="modal-title">ملاحظات تسميع الطالب : <span id="lessonNotesModalTitle"
                        class="text-success">asd</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-success" role="status"  id="lesson-notes-table-spinner" style="display: none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="table-responsive" id="lesson-notes-table" style="display: none">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>السورة</th>
                                <th>من الآية </th>
                                <th>إلى الآية</th>
                                <th style="width: 100px">التقييم</th>
                                <th>الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody id="lesson-notes-row">
                            <tr>
                                <td>السورة</td>
                                <td>من الآية </td>
                                <td>إلى الآية</td>
                                <td class="align-bottom">الملاحظات</td>
                                <td>الملاحظات</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer  justify-content-center ">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="width: 90%">إخفاء</button>
            </div>
        </div>
    </div>
</div>
