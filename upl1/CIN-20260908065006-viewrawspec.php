<?php
$sno = filter_input(INPUT_GET, 'sno', FILTER_VALIDATE_INT);
if (!$sno || $sno < 1) {
    echo '<div class="alert alert-danger">Invalid specification ID.</div>';
    return;
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo htmlspecialchars($headingname, ENT_QUOTES, 'UTF-8'); ?></h1>
        <ul>
            <li><a href="">Specification Detail</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=addrawmaterial">
                    <button type="button" class="btn btn-success" style="float:right; margin-left:15px">
                        Go Back
                    </button>
                </a>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
                    crossorigin="anonymous"></script>

                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable W-100">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close btn-primary" data-bs-dismiss="modal"
                                    aria-label="Close">x</button>
                            </div>

                            <div class="modal-body">
                                <?php
                                $detailStmt = mysqli_prepare(
                                    $con,
                                    "SELECT question, answer, comment, question2, answer2, comment2,
                                            question3, answer3, comment3, qid
                                     FROM tblrawspecdetail1
                                     WHERE product = ?"
                                );
                                $detailResult = false;
                                if ($detailStmt) {
                                    mysqli_stmt_bind_param($detailStmt, 'i', $sno);
                                    mysqli_stmt_execute($detailStmt);
                                    $detailResult = mysqli_stmt_get_result($detailStmt);
                                }
                                ?>

                                <h5 class="modal-title" id="staticBackdropLabel">Questions</h5>

                                <?php
                                $i = 0;
                                if ($detailResult) {
                                    while ($detailRow = mysqli_fetch_assoc($detailResult)) {
                                        $i++;
                                        ?>
                                        <div class="question-answer">
                                            <p class="question mt-3">
                                                <?php echo $i; ?>.)
                                                <?php echo htmlspecialchars($detailRow['question'], ENT_QUOTES, 'UTF-8'); ?>
                                            </p>

                                            <?php if (!empty($detailRow['answer'])) { ?>
                                                <div class="answers">
                                                    <p class="answer">
                                                        Answer:
                                                        <?php echo htmlspecialchars($detailRow['answer'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </p>
                                                    <input type="text" class="form-control"
                                                        value="Comment: <?php echo htmlspecialchars($detailRow['comment'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        readonly>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($detailRow['question2']) && !empty($detailRow['answer2'])) { ?>
                                                <p class="question mt-3">
                                                    <?php echo htmlspecialchars($detailRow['qid'], ENT_QUOTES, 'UTF-8'); ?>.)
                                                    <?php echo htmlspecialchars($detailRow['question2'], ENT_QUOTES, 'UTF-8'); ?>
                                                </p>
                                                <div class="answers">
                                                    <p class="answer">
                                                        Answer:
                                                        <?php echo htmlspecialchars($detailRow['answer2'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </p>
                                                    <input type="text" class="form-control"
                                                        value="Comment: <?php echo htmlspecialchars(isset($detailRow['comment2']) ? $detailRow['comment2'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                                                        readonly>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($detailRow['question3']) && !empty($detailRow['answer3'])) { ?>
                                                <p class="question mt-3">
                                                    <?php echo htmlspecialchars($detailRow['qid'], ENT_QUOTES, 'UTF-8'); ?>.)
                                                    <?php echo htmlspecialchars($detailRow['question3'], ENT_QUOTES, 'UTF-8'); ?>
                                                </p>
                                                <div class="answers">
                                                    <p class="answer">
                                                        Answer:
                                                        <?php echo htmlspecialchars($detailRow['answer3'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </p>
                                                    <input type="text" class="form-control"
                                                        value="Comment: <?php echo htmlspecialchars(isset($detailRow['comment3']) ? $detailRow['comment3'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                                                        readonly>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                }
                                if ($detailStmt) {
                                    mysqli_stmt_close($detailStmt);
                                }
                                ?>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $row = array();
        $row1 = array();

        $materialStmt = mysqli_prepare($con, "SELECT * FROM tblrawmaterial WHERE id = ? LIMIT 1");
        if ($materialStmt) {
            mysqli_stmt_bind_param($materialStmt, 'i', $sno);
            mysqli_stmt_execute($materialStmt);
            $materialResult = mysqli_stmt_get_result($materialStmt);
            $row = mysqli_fetch_array($materialResult);
            mysqli_stmt_close($materialStmt);
        }

        $specStmt = mysqli_prepare($con, "SELECT * FROM tblrawspecdetail WHERE product = ? LIMIT 1");
        if ($specStmt) {
            mysqli_stmt_bind_param($specStmt, 'i', $sno);
            mysqli_stmt_execute($specStmt);
            $specResult = mysqli_stmt_get_result($specStmt);
            $row1 = mysqli_fetch_array($specResult);
            mysqli_stmt_close($specStmt);
        }

        if (!$row || !$row1) {
            echo '<div class="alert alert-warning mt-3">Specification record was not found.</div>';
            return;
        }


        $snm = isset($row1['uploadby']) ? $row1['uploadby'] : '';
        //$snm = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $sgn1 = array('sign' => '');
        $signatureStmt = mysqli_prepare($con, "SELECT sign FROM tbladmin WHERE name = ? LIMIT 1");
        if ($signatureStmt) {
            mysqli_stmt_bind_param($signatureStmt, 's', $snm);
            mysqli_stmt_execute($signatureStmt);
            $signatureResult = mysqli_stmt_get_result($signatureStmt);
            $signatureFound = mysqli_fetch_array($signatureResult);
            if ($signatureFound) {
                $sgn1 = $signatureFound;
            }
            mysqli_stmt_close($signatureStmt);
        }

        $approvalDate = (!empty($row1['date']) && strtotime($row1['date']) !== false)
            ? date('d-m-Y', strtotime($row1['date']))
            : date('d-m-Y');
        ?>

        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card card-profile-1 mb-4">
                    <div class="card-body text-center">
                        <p class="mt-0">
                            Product:
                            <?php echo htmlspecialchars($row['pname'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p>
                            Product Code:
                            <?php echo htmlspecialchars($row['pcode'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p>
                            Uploaded by:
                            <?php echo htmlspecialchars($snm, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p>
                            Uploaded On:
                            <?php echo htmlspecialchars($approvalDate, ENT_QUOTES, 'UTF-8'); ?>

                        </p>

                        <p>Next Review Date: <?php if (!empty($row1['rdate']) && $row1['rdate'] != "0000-00-00") {
                            echo date('d-m-Y', strtotime($row1['rdate']));
                        } ?>
                        </p>


                        <?php if (!empty($sgn1['sign'])) { ?>
                            <img src="signature/<?php echo rawurlencode(basename($sgn1['sign'])); ?>"
                                alt="Approval signature" width="100">
                        <?php } ?>

                        <div>


                            <button type="button" class="btn pl-3 pr-3 pt-2 pb-2"
                                style="background-color:#663399; color:white;" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                View Detail
                            </button>


                            <a href="admin?id=editrawspec&sno=<?php echo $sno; ?>"><button type="button"
                                    class="btn pl-3 pr-3 pt-2 pb-2" style=" background-color:#663399; color:white; ">

                                    Edit Detail

                                </button></a>

                            <button type="button" class="btn btn-success pl-3 pr-3 pt-2 pb-2" id="approvedBtn"
                                aria-pressed="false" style="margin-left:6px;">
                                Approved Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-profile-1 mb-12">
                    <iframe src="specdetail/<?php echo rawurlencode(basename($row1['spec'])); ?>" height="400"
                        width="100%" id="cert2" title="Specification PDF"></iframe>
                </div>

                <?php include __DIR__ . '/approvedstamp.php'; ?>
            </div>
        </div>
    </div>
</div>