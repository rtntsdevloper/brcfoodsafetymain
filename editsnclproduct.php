<?php  
include 'connection.php';

$qid=$_GET['qid'];

$sql=mysqli_query($con,"select * from tblsnclproduct where id='$qid'");
$rows=mysqli_fetch_array($sql);
?>

                                   
								   <div class="col-12">
                                 
								 <form name="form1" action="editsnclproduct1" method="post" enctype="multipart/form-data">
								 <input type="hidden" name="qid" value="<?php echo $qid;?>" >
                                    <div class="row">

									 <div class="col-md-4">
                                      <div class="form-group">
                                                 <label id="error">Select Category</label>
                                      <select type="text" class="form-control border-input"  name="cate" required  >
									  <option value="<?php echo $rows['cate'];?>"><?php echo $rows['cate'];?></option>
									  </select>
                                                 </div>
                                        </div>
									
                                     <div class="col-md-4">
                                      <div class="form-group" id="chkproduct">
                                                 <label id="error">Select Product</label>
                                      <input type="text" class="form-control border-input"   disabled="disabled" value="<?php echo $rows['name'];?>" >
                                                 </div>
                                        </div>
                                       

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Quantity</label>
                                                <input type="text" class="form-control border-input"   name="qty"  required value="<?php echo $rows['qty'];?>" >
                                            </div>
                                        </div>
										
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Use By</label>
                                                <input type="date" class="form-control border-input"   name="useby" required value="<?php echo $rows['useby'];?>" >
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Batch Code</label>
                                                <input type="text" class="form-control border-input"   name="batch" required value="<?php echo $rows['batchcode'];?>" >
                                            </div>
                                        </div>
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Weight</label>
                                                <input type="text" class="form-control border-input"   name="weight" required  value="<?php echo $rows['weight'];?>" >
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Upload Pics</label>
                                                <input type="file" class="form-control border-input"   name="img[]"  multiple  accept="image/*,.jpg,.gif,.png,.jpeg">
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label >Comment</label>
                                                <textarea  class="form-control border-input"   name="cmnt"><?php echo $rows['cmnt'];?></textarea>
                                            </div>
                                        </div>
										
                                    </div>

                                        <div class="text-center">
                                          <button type="submit" name="submitt" class="btn btn-info btn-fill btn-wd">Submit</button>
                                          </div>
                                      
                                </form>
								