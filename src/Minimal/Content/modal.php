<!-- Modal -->
<div class="modal fade" id="modal-<?= /** @noinspection PhpUndefinedVariableInspection */
$areaName?>" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Select content type</h4>
            </div>
            <div class="modal-body">
                <?= /** @noinspection PhpUndefinedVariableInspection */
                $elements ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Cancel
                </button>
                <button type="button" class="btn btn-primary">Next
                </button>
            </div>
        </div>
    </div>
</div>