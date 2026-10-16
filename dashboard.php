<div class="main-content">
  <div class="breadcrumb">
    <h1 class="mr-2"><?php echo $headingname; ?></h1>
    <ul>
      <li><a href="">Dashboard</a></li>
      <li>Home</li>
    </ul>
  </div>


  <div class="separator-breadcrumb border-top"></div>
  <div class="row">
    <!-- ICON BG-->

    <?php
    if ($access == "Admin") {

      $sq = mysqli_query($con, "select * from tbltabs where status1='mgmt'");
      while ($qr = mysqli_fetch_array($sq)) {
    ?>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <a href='<?php echo $qr['weblink']; ?>'>
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
              <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:<?php echo $qr['color']; ?>"></i>
                <div class="content">
                  <p class="text-muted mt-2 mb-0"><?php echo $qr['name']; ?></p>
                  <p class="text-primary text-22 line-height-1 mb-2"><?php echo $qr['name1']; ?></p>
                </div>
              </div>
            </div>
          </a>
        </div>
      <?php
      }

      ?>

    <?php
    }
    if ($access == "Auditee" || $access == "Auditor" || $access == "superadmin") {
    ?>
      <?php
      $string = $tabs;
      $array = explode(";", $string);
      $data = array();
      foreach ($array as $arr) {
        $sq = mysqli_query($con, "select * from tbltabs where sno='$arr' and status !='mgmt'");
        while ($qr = mysqli_fetch_array($sq)) {

      ?>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href='<?php echo $qr['weblink']; ?>'>
              <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:<?php echo $qr['color']; ?>"></i>
                  <div class="content">
                    <p class="text-muted mt-2 mb-0"><?php echo $qr['name']; ?></p>
                    <p class="text-primary text-22 line-height-1 mb-2"><?php echo $qr['name1']; ?></p>
                  </div>
                </div>
              </div>
            </a>
          </div>
      <?php
        }
      }
      ?>

    <?php
    }
    ?>
  </div>
  <div class="row">
    <!-- ICON BG-->


    <?php
    $tb = mysqli_query($con, "select * from tblstaff");
    $tbr = mysqli_fetch_array($tb);
    $usr = mysqli_num_rows($tb);

    $tb1 = mysqli_query($con, "select * from tbladmin");
    $tbr1 = mysqli_fetch_array($tb1);
    $adm = mysqli_num_rows($tb1);


    $tb2 = mysqli_query($con, "select * from tblauditor");
    $tbr2 = mysqli_fetch_array($tb2);
    $adtr = mysqli_num_rows($tb2);

    $tb3 = mysqli_query($con, "select * from tblauditee");
    $tbr3 = mysqli_fetch_array($tb3);
    $adte = mysqli_num_rows($tb3);


    $tb4 = mysqli_query($con, "select * from tblnewcomplaint");
    $tbr4 = mysqli_fetch_array($tb4);
    $comp = mysqli_num_rows($tb4);



    $d11 = date("Y-m-01");
    $d22 = date("Y-m-31");



    $tb5 = mysqli_query($con, "select * from tblroster where date between '$d11' and '$d22'");
    $tbr5 = mysqli_fetch_array($tb5);
    $auditda = mysqli_num_rows($tb5);

    ?>



    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
      <!-- <div class="col-lg-6 col-md-12">
          
            <div class="row">
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                  <div class="card-body text-center"><i class="fa fa-list" style="color:#0000FF; font-size:20px"></i>
                    <p class="text-muted mt-2 mb-2">Total Admin</p>
                    <p class="text-primary text-24 line-height-1 m-0"><?php echo $adm; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                  <div class="card-body text-center"><i class="fa fa-list" style="color:#FF0000; font-size:20px"></i>
                    <p class="text-muted mt-2 mb-2">Total Users</p>
                    <p class="text-primary text-24 line-height-1 m-0"><?php echo $usr; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                  <div class="card-body text-center"><i class="fa fa-list" style="color:#CC9933; font-size:20px"></i>
                    <p class="text-muted mt-2 mb-2">Total Auditor</p>
                    <p class="text-primary text-24 line-height-1 m-0"><?php echo $adtr; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-big mb-4">
                  <div class="card-body text-center"><i class="fa fa-list" style="color:#66CC33; font-size:20px"></i>
                    <p class="text-muted mt-2 mb-2">Total Auditee</p>
                    <p class="line-height-1 text-title text-18 mt-2 mb-0"><?php echo $adte; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-big mb-4">
                  <div class="card-body text-center"><i class="fa fa-list" style="color:#008040; font-size:20px"></i>
                    <p class="text-muted mt-2 mb-2">Total Complaints</p>
                    <p class="line-height-1 text-title text-18 mt-2 mb-0"><?php echo $comp; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-big mb-4">
                  <div class="card-body text-center"><i class="fa fa-list" style="color:#FF0080; font-size:20px"></i>
                    <p class="text-muted mt-2 mb-2">Total Audit</p>
                    <p class="line-height-1 text-title text-18 mt-2 mb-0"><?php echo $auditda; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">General Compliance <a href="admin.php?id=brccompliance"><button class="btn btn-danger" style="float:right">View</button></a></div>
            <div class="ul-widget-app__browser-list">
              <?php
              $sql = mysqli_query($con, "select * from addtest1 where status2='active'");
              $i = 0;
              while ($rows = mysqli_fetch_array($sql)) {
                $i++;
              ?>
                <a href="admin.php?id=brccompliance"> <button class="btn btn-<?php echo $rows['bgcolor']; ?> btn-rounded m-1" type="button" style=" color:#FFFFFF;background:<?php echo $rows['bgcolor']; ?>">
                    <?php echo $i; ?>.&nbsp;&nbsp;<?php echo $rows['subject']; ?></button> </a>

              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>









<!-- alerts  -->


      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Latest Alerts <a href="admin.php?id=knowledge"><button class="btn btn-danger" style="float:right">View</button></a></div>

            <div class="notice-board">
              <div class="notices-wrapper">
                <div class="notices" id="notices"></div>
              </div>
            </div>




            <?php
            $sqlnotice = mysqli_query($con, "SELECT t1.name as aname, t2.date, t2.ques, t2.weblink FROM tblalert1 t1 JOIN tblalerts t2 ON t1.id = t2.status ORDER BY t2.date DESC LIMIT 12");
            $noticeop = array();

            foreach ($sqlnotice as $rownotice) {
              $daten = date('d-m-Y', strtotime($rownotice['date']));
              $noticeop[] = [
                'title' => $rownotice['aname'],
                'content' => $rownotice['ques'],
                'link' => $rownotice['weblink'],
                'daten' => $daten
              ];
            }
            ?>

            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const noticesContainer = document.getElementById('notices');
                const notices = <?php echo json_encode($noticeop); ?>;

                // Check if we have notices
                if (notices.length === 0) {
                  noticesContainer.innerHTML = '<div class="notice"><div class="notice-content">No upcoming audits found</div></div>';
                  return;
                }

                // Add notices twice for seamless scrolling
                notices.forEach(notice => {
                  addNotice(notice.title, notice.content, notice.link, notice.daten);
                });
                notices.forEach(notice => {
                  addNotice(notice.title, notice.content, notice.link, notice.daten);
                });

                // Start continuous scrolling
                startContinuousScroll();

                function addNotice(title, content, link, daten) {
                  const noticeElement = document.createElement('div');
                  noticeElement.className = 'notice';
                  noticeElement.innerHTML = `
      <div class="notice-header">
        <h5 class="notice-title">${title}</h5>
        <a href="${link}" class="btn btn-warning btn-sm" target="_blank">View</a>
      </div>
      <div class="notice-content">${content}</div>
      <div class="notice-date">${daten}</div>
    `;
                  noticesContainer.appendChild(noticeElement);
                }

                function startContinuousScroll() {
                  const scrollSpeed = 0.2; // Adjust speed (lower = slower)
                  const containerHeight = noticesContainer.parentElement.clientHeight;
                  let position = 290;
                  let isPaused = false;

                  function scrollStep() {
                    if (!isPaused) {
                      position -= scrollSpeed;

                      // Reset to start when scrolled through one set of notices
                      if (Math.abs(position) >= noticesContainer.scrollHeight / 2) {
                        position = 0;
                      }

                      noticesContainer.style.transform = `translateY(${position}px)`;
                    }
                    requestAnimationFrame(scrollStep);
                  }

                  // Start scrolling
                  scrollStep();

                  // Pause on hover
                  noticesContainer.closest('.notice-board').addEventListener('mouseenter', () => {
                    isPaused = true;
                  });

                  noticesContainer.closest('.notice-board').addEventListener('mouseleave', () => {
                    isPaused = false;
                  });
                }
              });

              // Add CSS
              const style = document.createElement('style');
              style.textContent = `
  .notice-board {
    height: 400px;
    overflow: hidden;
    position: relative;
    border-radius: 8px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
  }
  
  .notices-wrapper {
    height: 100%;
    overflow: hidden;
  }
  
  .notices {
    transition: transform 0.1s linear;
  }
  
  .notice {
    padding: 15px;
    margin: 10px;
    background: white;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #007bff;
    transition: all 0.3s ease;
  }
  
  .notice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
  }
  
  .notice-title {
    margin: 0;
    font-size: 17px;
    font-weight: 600;
    color: #2c3e50;
  }
  
  .notice-content {
    color: #6c757d;
    font-size: 15px;
  }
     .notice-date {
    color: #043968ff;
    font-size: 16px;
    margin-top: 10px;
  }
  
  .notice:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }
`;
              document.head.appendChild(style);
            </script>




          </div>

        </div>
      </div>





<!-- 
alerts end -->













      <!-- fsc survey -->

      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body p-0">
            <h5 class="card-title m-0 p-3">FSCSURVEY TRENDING <a href="admin.php?id=fscsurveytrendings"><button class="btn btn-warning" style="float:right">View</button></a></h5>
            <div id="echartBar" style="height: 300px;"></div>
          </div>
        </div>
      </div>
      <?php

      $year = date("Y");
      $month = date("m");


      $date1 = $year . "-01-01";
      $date2 = $year . "-12-31";


      $sq = mysqli_query($con, "select distinct name  from competency3  where (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
      $row = mysqli_fetch_array($sq);
      $totalstudent = mysqli_num_rows($sq);

      $sq1 = mysqli_query($con, "select distinct correct  from competency");
      $row1 = mysqli_fetch_array($sq1);
      $section = mysqli_num_rows($sq1);

      $sq2 = mysqli_query($con, "select *  from competency");
      $row2 = mysqli_fetch_array($sq2);
      $question = mysqli_num_rows($sq2);

      $a = mysqli_query($con, "select * from competency3 where correct='Leadership and vision' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
      $a1 = mysqli_num_rows($a);

      $aa = mysqli_query($con, "select * from competency where correct='Leadership and vision' ");
      $aa1 = mysqli_num_rows($aa);

      $totalmatch = $aa1 * 5 * $totalstudent;

      $totalpass1 = $aa1 * 5 * $totalstudent;
      $totalfail1 = $a1 * 5;

      $tf1 = $totalpass1 - $totalfail1;

      $totalpass = $aa1 * 5 * $totalstudent;
      $totalfail = $a1 * 5;

      $totalpass = round($totalpass / $totalmatch * 100);
      $totalfail = round($totalfail / $totalmatch * 100);

      $ap = mysqli_query($con, "select *  from competency3 where correct='Workplace' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
      $a1p = mysqli_num_rows($ap);

      $aap = mysqli_query($con, "select *  from competency where correct='Workplace'");
      $aa1p = mysqli_num_rows($aap);

      $totalmatchp = $aa1p * 5 * $totalstudent;

      $totalpass1p = $aa1p * 5 * $totalstudent;
      $totalfail1p = $a1p * 5;

      $tf2 = $totalpass1p - $totalfail1p;


      $totalpassp = $aa1p * 5 * $totalstudent;
      $totalfailp = $a1p * 5;

      $totalpassp = round($totalpassp / $totalmatchp * 100);
      $totalfailp = round($totalfailp / $totalmatchp * 100);

      $ja = mysqli_query($con, "select * from competency3 where correct='Staff Knowledge and Actions' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
      $ja1 = mysqli_num_rows($ja);

      $jaa = mysqli_query($con, "select * from competency where correct='Staff Knowledge and Actions'");
      $jaa1 = mysqli_num_rows($jaa);

      $jtotalmatch = $jaa1 * 5 * $totalstudent;

      $jtotalpass1 = $jaa1 * 5 * $totalstudent;
      $jtotalfail1 = $ja1 * 5;

      $tf3 = $jtotalpass1 - $jtotalfail1;

      $jtotalpass = $jaa1 * 5 * $totalstudent;
      $jtotalfail = $ja1 * 5;

      $jtotalpass = round($jtotalpass / $jtotalmatch * 100);
      $jtotalfail = round($jtotalfail / $jtotalmatch * 100);

      ?>
      <script language="javascript">
        "use strict";

        $(document).ready(function() {
          // Chart in Dashboard version 1
          var echartElemBar = document.getElementById('echartBar');

          if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
              legend: {
                borderRadius: 0,
                orient: 'horizontal',
                x: 'right',
                data: ['Allocated total score of questionnaires', 'Score received as per questionnaires']
              },
              grid: {
                left: '8px',
                right: '8px',
                bottom: '0',
                containLabel: true
              },
              tooltip: {
                show: true,
                backgroundColor: 'rgba(0, 0, 0, .8)'
              },
              xAxis: [{
                type: 'category',
                data: ['Leadership and vision', 'Workplace', 'Staff Knowledge and Actions'],
                axisTick: {
                  alignWithLabel: true
                },
                splitLine: {
                  show: false
                },
                axisLine: {
                  show: true
                }
              }],
              yAxis: [{
                type: 'value',
                axisLabel: {
                  formatter: '{value}'
                },
                min: 0,
                max: <?php echo $totalpass1; ?>,
                interval: 25000,
                axisLine: {
                  show: false
                },
                splitLine: {
                  show: true,
                  interval: 'auto'
                }
              }],
              series: [{
                name: 'Allocated total score of questionnaires',
                data: [<?php echo $totalpass1; ?>, <?php echo $totalpass1p; ?>, <?php echo $jtotalpass1; ?>],
                label: {
                  show: false,
                  color: '#0168c1'
                },
                type: 'bar',
                barGap: 0,
                color: '#bcbbdd',
                smooth: true,
                itemStyle: {
                  emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowOffsetY: -2,
                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                  }
                }
              }, {
                name: 'Score received as per questionnaires',
                data: [<?php echo $totalfail1; ?>, <?php echo $totalfail1p; ?>, <?php echo $jtotalfail1; ?>],
                label: {
                  show: false,
                  color: '#639'
                },
                type: 'bar',
                color: '#7569b3',
                smooth: true,
                itemStyle: {
                  emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowOffsetY: -2,
                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                  }
                }
              }]
            });
            $(window).on('resize', function() {
              setTimeout(function() {
                echartBar.resize();
              }, 500);
            });
          } // Chart in Dashboard version 1


        });
      </script>


      <?php

      $sqli = mysqli_query($con, "SELECT * FROM `tblemailtrack`");
      $total = mysqli_num_rows($sqli);

      if ($total <= 0) {
        $new1 = 0;
        $new = 0;
        $progress1 = 0;
        $progress = 0;
        $info = 0;
        $info1 = 0;
        $done1 = 0;
        $done = 0;
      } else {

        $sql2 = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE status != 'Info Only' and status !='Completed' ");
        $progress = mysqli_num_rows($sql2);
        $progress1 = round($progress / $total * 100);


        $sql3 = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE status = 'Info Only' ");
        $info = mysqli_num_rows($sql3);
        $info1 = round($info / $total * 100);

        $sql4 = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE status = 'Completed'");
        $done = mysqli_num_rows($sql4);
        $done1 = round($done / $total * 100);
      }


      ?>
      <script>
        $(document).ready(function() {
          var echartElemPie3 = document.getElementById('echartPie3');

          if (echartElemPie3) {
            var echartPie3 = echarts.init(echartElemPie3);
            echartPie3.setOption({
              color: ['#62549c', '#FF9900', '#999900'],
              tooltip: {
                show: true,
                backgroundColor: 'rgba(0, 0, 0, .8)'
              },
              series: [{
                name: 'Email Tracking',
                type: 'pie',
                radius: '60%',
                center: ['50%', '50%'],
                data: [{
                  value: <?php echo $progress1; ?>,
                  name: 'In Progress'
                }, {
                  value: <?php echo $info1; ?>,
                  name: 'Info Only'
                }, {
                  value: <?php echo $done1; ?>,
                  name: 'Closed-Off'
                }],
                itemStyle: {
                  emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                  }
                }
              }]
            });
            $(window).on('resize', function() {
              setTimeout(function() {
                echartPie3.resize();
              }, 500);
            });
          }
        });
      </script>







      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="card-title">Email Tracking <a href="admin.php?id=email_tracking"><button class="btn btn-primary" style="float:right">View</button></a></div>
            <div class="row">
              <div class="col-md-6">
                <table class="table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Email</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Total Recieved</td>
                      <td class="font-weight-bold text-success"><?php echo $total; ?></td>
                    </tr>
                    <tr>
                      <td>In Progress</td>
                      <td class="font-weight-bold"><?php echo $progress; ?></td>
                    </tr>
                    <tr>
                      <td>Info Only</td>
                      <td class="text-danger"><?php echo $info; ?></td>
                    </tr>
                    <tr>
                      <td>Closed-off</td>
                      <td class="text-warning font-weight-bold"><?php echo $done; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <div id="echartPie3" style="height: 200px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>







      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="card-title">Monthly Management Meeting <a href="admin.php?id=monthly_meeting"><button class="btn btn-warning" style="float:right">View</button></div>
            <?php
            $sql = mysqli_query($con, "SELECT * FROM `tbl_meeting` order by mdate DESC limit 3");


            $i = 0;
            // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
            while ($y = mysqli_fetch_array($sql)) {
              $i++;

            ?>
              <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                <h5><a href=""><?php echo date("d-m-Y", strtotime($y['mdate'])); ?> &nbsp;&nbsp;&nbsp;</a></h5>
                <div class="flex-grow-1">
                  <h5><a href="">Attendees</a></h5>
                  <p class="m-0 text-small text-muted"><?php
                                                        $empnm = explode(';', $y['attend']);
                                                        $desig = explode(';', $y['desig']);
                                                        foreach ($empnm as $key => $value) {

                                                          echo $value . " ( " . $desig[$key] . ") <br>";
                                                        } ?></p>
                  <p class="text-small text-danger m-0">Minute taken (<?php echo $y['mntk']; ?>)

                  </p>
                </div>
                <div>
                  <a href="admin.php?id=monthly_review_report&sno=<?php echo $y['id']; ?>"> <button class="btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm">
                      View details
                    </button></a>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>

      <!-- gmp trending -->
      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="card-title">GMP TRENDING <a href="admin.php?id=gmptrending"><button class="btn btn-danger" style="float:right">View</button></a></div>
            <canvas id="auditChartg" style="height: 500px; width: 100%;" class="my-5"></canvas>

          </div>
        </div>
      </div>
      <?php

      if ($month == "") {
        $month = date("m");
      }

      if ($year == "") {
        $year = date("Y");
      }

      $date1 = $year . "-01-01";
      $date2 = date("Y-m-t", strtotime($date1));

      $d1 = date("d-m-Y", strtotime($date1));
      $d2 = date("d-m-Y", strtotime($date2));
      $mnth = date("F", strtotime($date1));


      $ghy = mysqli_query($con, "select * from tblauditsection where name='GMP Audit'");
      $ghy1 = mysqli_fetch_array($ghy);

      $sid = $ghy1['id'];


      $sql0 = mysqli_query($con, "select t1.name as section,t2.*,t3.*,t2.id as sd,t2.id AS sno, t2.date as auditdate , t4.name as auditor,t5.name as auditee from tblauditsection1 t1, tblgmpaudit2 t2, tblgmpaudit3 t3, tblauditor t4, tblauditee t5 where (t2.date BETWEEN '$date1' and '$date2') and t2.audit='$sid'  and t1.sid=t2.audit and t1.id=t2.sid and t3.sno=t2.id and t4.id=t2.auditor and t5.id=t2.auditee group by t2.sid,t2.auditor,t2.auditee,t2.date ");
      $i = 1;
      while ($rows0 = mysqli_fetch_array($sql0)) {
        $auditdate = date("d-m-Y", strtotime($rows0['auditdate']));


        $major = mysqli_query($con, "select * from tblgmpaudit3 where ans='Major' and sno='$rows0[sd]'");
        $major1 = mysqli_num_rows($major);


        $minor = mysqli_query($con, "select * from tblgmpaudit3 where ans='Minor' and sno='$rows0[sd]'");
        $minor1 = mysqli_num_rows($minor);


        $compliant = mysqli_query($con, "select * from tblgmpaudit3 where ans='Compliant' and sno='$rows0[sd]'");
        $compliant1 = mysqli_num_rows($compliant);


        $chartData[] = [
          'section' => $rows0['section'],   // Pulls 'section' value from $rows0 array
          'major' => $major1,               // Assigns value from $major1 variable
          'minor' => $minor1,               // Assigns value from $minor1 variable
          'compliant' => $compliant1        // Assigns value from $compliant1 variable
        ];


        $chartDataJson = json_encode($chartData); // Converts the array to a JSON string
      }

      ?>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
        const chartDatag = <?php echo $chartDataJson; ?>;

        if (chartDatag.length > 0) {
          const labels = chartDatag.map(item => item.section);
          const majorData = chartDatag.map(item => item.major);
          const minorData = chartDatag.map(item => item.minor);
          const compliantData = chartDatag.map(item => item.compliant);

          const ctx = document.getElementById('auditChartg').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                  label: 'Major',
                  data: majorData,
                  backgroundColor: 'rgba(255, 99, 132, 0.7)',
                },
                {
                  label: 'Minor',
                  data: minorData,
                  backgroundColor: 'rgba(54, 162, 235, 0.7)',
                },
                {
                  label: 'Compliant',
                  data: compliantData,
                  backgroundColor: 'rgba(75, 192, 104, 0.7)',
                }
              ]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        }
      </script>


      <!-- gmp trending end -->





      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="card-title">Monthly Task Management <a href="admin.php?id=psdtaskview"><button class="btn btn-primary" style="float:right">View</button></a></div>

            <?php
            include 'connection_psd.php';


            if (isset($_GET['year'])) {
              $taskyear = $_GET['year'];
            } else {
              $taskyear = date('Y');
            }
            if (isset($_GET['month'])) {
              $taskmonth = $_GET['month'];
            } else {
              $taskmonth = date('m');
            }

            $tmonth = $taskmonth . '-' . $taskyear;


            $sqli = mysqli_query($pcon, "SELECT * FROM tbltask WHERE customer = '$psdcust' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth';");
            $total = mysqli_num_rows($sqli);

            if ($total <= 0) {
              $new1 = 0;
              $new = 0;
              $progress1 = 0;
              $progress = 0;
              $notstart1 = 0;
              $notstart = 0;
              $done1 = 0;
              $done = 0;
            } else {

              $sql2 = mysqli_query($pcon, "select * from tbltask where status='In Progress'  and customer='$psdcust' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth' ");
              $progress = mysqli_num_rows($sql2);
              $progress1 = round($progress / $total * 100);

              $sql3 = mysqli_query($pcon, "SELECT * FROM tbltask WHERE (status = 'Not Started' OR status = 'Not Assign' OR status = 'New') AND customer = '$psdcust'AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'; ");
              $notstart = mysqli_num_rows($sql3);
              $notstart1 = round($notstart / $total * 100);

              $sql4 = mysqli_query($pcon, "select * from tbltask where status='Done'  and customer='$psdcust' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
              $done = mysqli_num_rows($sql4);
              $done1 = round($done / $total * 100);
            }

            ?>

            <table class="table">
              <tr>
                <th>S no.</th>
                <th>Projects</th>
                <th>Total Task</th>
                <th>Task Pending</th>
                <th>Task Completed</th>
                <th>Progress By Task</th>
              </tr>
              <tbody class="table-group-divider">
                <?php

                $i = 1;
                $tmonth = date('m-Y');


                $sq = mysqli_query($pcon, "select distinct project from tbltask where customer='$psdcust' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'  ");

                while ($datarows = mysqli_fetch_array($sq)) {

                  $sq1 = mysqli_query($pcon, "select * from tblproject where id='$datarows[project]' ");
                  $rows1 = mysqli_fetch_array($sq1);

                  $tstotal = mysqli_query($pcon, "SELECT * from tbltask where  customer='$psdcust' and project='$datarows[project]' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
                  $tasktotal = mysqli_num_rows($tstotal);



                  // print_r("SELECT * FROM tbltask WHERE (status = 'Not Started' OR status='In Progress'  OR status = 'Not Assign' OR status = 'New') AND customer = '$sno' AND project='$datarows[project]");
                  $sqlpro = mysqli_query($pcon, "SELECT * FROM tbltask WHERE (status = 'Not Started' OR status='In Progress'  OR status = 'Not Assign' OR status = 'New') AND customer = '$psdcust' AND project='$datarows[project]' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
                  $tprogress = mysqli_num_rows($sqlpro);

                  $sqldone = mysqli_query($pcon, "SELECT * from tbltask where status='Done' AND customer = '$psdcust' AND project='$datarows[project]' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
                  $tdone = mysqli_num_rows($sqldone);
                  if ($tdone > 0) {
                    $rdone1 = round($tdone / $tasktotal * 100);
                  } else {
                    $rdone1 = 0;
                  }

                ?>
                  <tr>
                    <th><?php echo $i; ?></th>
                    <th><?php echo $rows1['name']; ?></th>
                    <th class="text-primary"><?php echo $tasktotal; ?></th>
                    <th class="text-warning"><?php echo $tprogress; ?></th>
                    <th class="text-success"><?php echo $tdone; ?></th>
                    <th>
                      <div class="progress mt-3">
                        <div class="progress-bar bg-info 
									<?php if ($rdone1 == 0) {
                    echo "text-info";
                  } ?>" role="progressbar" style="width: <?php echo  $rdone1; ?>%" aria-valuenow="<?php echo $rdone1; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $rdone1; ?>%</div>
                      </div>
                    </th>
                  </tr>
                <?php
                  $i++;
                }
                ?>
              </tbody>
            </table>


          </div>
        </div>
      </div>


      <!-- end of row-->

      <!-- end of col-->

      <!-- end of col-->
      <!-- travel-different-countries-->

      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="card-title">Horizon Scanning <a href="admin.php?id=knowledge"><button class="btn btn-info" style="float:right">View</button></a></div>
            <?php
            $sql1 = mysqli_query($con, "select * from tblalert1 where status='alerts'");
            $colors = array();
            $j = 0;
            $clr = "";
            while ($row1 = mysqli_fetch_array($sql1)) {
              $j++;


              $sql = mysqli_query($con, "select * from tblalerts where status='$row2[id]'");
              $mtch = mysqli_num_rows($sql);


            ?>
              <div class="ul-widget-app__poll-list mb-4">
                <h3 class="heading mr-2"><?php echo $row1['name']; ?></h3>
                <div class="d-flex"><span class="t-font-boldest ml-auto"><?php $mtch; ?></span></div>
                <div class="progress progress--height-2 mb-3">
                  <?php

                  if ($j == 0) {
                    $clr = "info";
                    echo '<div class="progress-bar bg-"' . $clr . '" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  }
                  if ($j == 1) {
                    $clr = "primary";
                    echo '<div class="progress-bar bg-"' . $clr . '" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  }
                  if ($j == 2) {
                    $clr = "danger";
                    echo '<div class="progress-bar bg-"' . $clr . '" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  }
                  if ($j == 3) {
                    $clr = "warning";
                    echo '<div class="progress-bar bg-"' . $clr . '" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  }

                  if ($j == 4) {
                    $clr = "success";
                    echo '<div class="progress-bar bg-"' . $clr . '" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  } ?>


                </div>
              </div>

            <?php
            }
            ?>

          </div>
        </div>
      </div>



















      <?php
      $monthlyData = [];

      for ($i = 1; $i <= 12; $i++) {
        if ($i < 10) {
          $mname = '0' . $i . '-' . $year;
        } else {
          $mname = $i . '-' .  $year;
        }

        $chart1 = mysqli_query($con, "SELECT 
        t1.subject AS section,
        t6.subtest AS subsection,
        t2.*,              
        t3.*,             
        t2.sid AS sid,     
        t2.id AS sno,     
        t2.date AS auditdate,
        t4.name AS auditor,
        t5.name AS auditee
    FROM 
        addtest1 t1,
        tblroster t2,
        saveaudit t3,
        tblauditor t4,
        tblauditee t5,
        subtest t6
    WHERE 
        DATE_FORMAT(t2.date, '%m-%Y') = '$mname'
        AND t3.sno = t2.id
        AND t6.sid = t2.sid
        AND t1.testid = t2.tid
        AND t4.id = t2.auditor
        AND t5.id = t2.auditee
    GROUP BY 
        t2.sid, t2.auditor, t2.auditee");

        // Initialize monthly counters
        $monthCritical = 0;
        $monthMinor = 0;
        $monthMajor = 0;
        $monthCompliant = 0;
        $monthTotal = 0;

        while ($chart2 = mysqli_fetch_array($chart1)) {
          $aauditdate = date("d-m-Y", strtotime($chart2['auditdate']));

          $amajor = mysqli_query($con, "select * from saveaudit where ans='Major' and sid='$chart2[sid]' and sno='$chart2[sno]'");
          $cmajor1 = mysqli_num_rows($amajor);

          $aminor = mysqli_query($con, "select * from saveaudit where ans='Minor' and sid='$chart2[sid]'  and sno='$chart2[sno]'");
          $cminor1 = mysqli_num_rows($aminor);

          $acompliant = mysqli_query($con, "select * from saveaudit where ans='Compliant' and sid='$chart2[sid]'  and sno='$chart2[sno]'");
          $ccompliant1 = mysqli_num_rows($acompliant);

          $acritical = mysqli_query($con, "select * from saveaudit where ans='Critical' and sid='$chart2[sid]' and sno='$chart2[sno]'");
          $ccritical1 = mysqli_num_rows($acritical);

          // Accumulate counts for the month
          $monthCritical += $ccritical1;
          $monthMinor += $cminor1;
          $monthMajor += $cmajor1;
          $monthCompliant += $ccompliant1;
        }

        // Calculate total for the month
        $monthTotal = $monthCritical + $monthMinor + $monthMajor + $monthCompliant;

        // Store data for the month
        $monthName = DateTime::createFromFormat('m-Y', $mname)->format('M Y');
        $monthlyData[$monthName] = [
          "Critical" => $monthCritical,
          "Minor" => $monthMinor,
          "Major" => $monthMajor,
          "Compliant" => $monthCompliant,
          "Total" => $monthTotal
        ];
      }
      // Prepare data for each category (including Total as a separate bar)
      $categories = ["Critical", "Minor", "Major", "Compliant", "Total"];
      $chartData = [];

      foreach ($categories as $category) {
        $dataPoints = [];
        foreach ($monthlyData as $month => $values) {
          $dataPoints[] = array("label" => $month, "y" => $values[$category]);
        }

        // Customize the Total series to make it stand out
        if ($category === "Total") {
          $chartData[] = array(
            "type" => "column",
            "name" => $category,
            "showInLegend" => true,
            "color" => "#000080", // Black color for Total
            "dataPoints" => $dataPoints
          );
        } else {
          $chartData[] = array(
            "type" => "column",
            "name" => $category,
            "showInLegend" => true,
            "dataPoints" => $dataPoints
          );
        }
      }
      ?>
      <script>
        window.onload = function() {
          var chartisa = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1",
            title: {
              text: "Monthly Audit Summary - <?php echo $year; ?>"
            },
            axisX: {
              title: "Months",
              labelAngle: 0
            },
            axisY: {
              title: "Number of Findings",
              includeZero: true
            },
            toolTip: {
              shared: true
            },
            legend: {
              cursor: "pointer",
              itemclick: function(e) {
                e.dataSeries.visible = !(typeof e.dataSeries.visible === "undefined" || e.dataSeries.visible);
                chartisa.render();
              }
            },
            data: <?php echo json_encode($chartData, JSON_NUMERIC_CHECK); ?>
          });

          chartisa.render();
        }
      </script>

      <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
      <!-- mutual-friend-->

      <!-- notification-->
      <!-- <div class="col-lg-6 col-md-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">ISA TRENDING <a href="admin.php?id=isatrending"><button class="btn btn-primary" style="float:right">View</button></a></div>
              <div id="chartContainer" style="height: 450px; width: 100%;"></div>


            </div>
          </div>
        </div> -->







      <?php

      $date11 = date('Y-m-') . "01";
      $date21 = date('Y-m-') . "31";


      $ts = mysqli_query($con, "select * from tblroster  where (date BETWEEN '$date11' and '$date21')  and status='Done'");
      $trs = mysqli_num_rows($ts);


      $ts1 = mysqli_query($con, "select * from tblroster  where (date BETWEEN '$date11' and '$date21')  ");
      $trs1 = mysqli_num_rows($ts1);

      $ts2 = mysqli_query($con, "select * from tblroster  where (date BETWEEN '$date11' and '$date21')  and status='Due'");
      $trs2 = mysqli_num_rows($ts2);

      $ts3 = mysqli_query($con, "select * from tblroster  where (date BETWEEN '$date11' and '$date21')  and status='In Progress'");
      $trs3 = mysqli_num_rows($ts3);
      ?>

      <script>
        $(document).ready(function() {
          var echartElemPie4 = document.getElementById('echartPie4');

          if (echartElemPie4) {
            var echartPie4 = echarts.init(echartElemPie4);
            echartPie4.setOption({
              color: ['#62549c', '#339933', '#CC3300', '#999900'],
              tooltip: {
                show: true,
                backgroundColor: 'rgba(0, 0, 0, .8)'
              },
              series: [{
                name: 'Email Tracking',
                type: 'pie',
                radius: '60%',
                center: ['50%', '50%'],
                data: [{
                  value: <?php echo $trs1; ?>,
                  name: 'Total Audit'
                }, {
                  value: <?php echo $trs; ?>,
                  name: 'Completed'
                }, {
                  value: <?php echo $trs2; ?>,
                  name: 'Not Started'
                }, {
                  value: <?php echo $trs3; ?>,
                  name: 'In Progress'
                }],
                itemStyle: {
                  emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                  }
                }
              }]
            });
            $(window).on('resize', function() {
              setTimeout(function() {
                echartPie4.resize();
              }, 500);
            });
          }
        });
      </script>

      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="card-title">Internal Audit Tracking <a href="admin.php?id=auditdetail"><button class="btn btn-primary" style="float:right">View</button></a></div>
            <div class="row">
              <div class="col-md-6">
                <table class="table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Internal Audit</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Total Audit</td>
                      <td class="font-weight-bold text-primary"><?php echo $trs1; ?></td>
                    </tr>
                    <tr>
                      <td>Completed</td>
                      <td class="font-weight-success"><?php echo $trs; ?></td>
                    </tr>
                    <tr>
                      <td>Not Started</td>
                      <td class="text-danger"><?php echo $trs2; ?></td>
                    </tr>
                    <tr>
                      <td>In Progress</td>
                      <td class="text-warning"><?php echo $trs3; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <div id="echartPie4" style="height: 200px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>





<!-- //monthly complaints trending -->
      <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
          <div class="card-body">
        <?php
        $cyear = date("Y");
        // Generate month array for current year
        $compraw = [];
        for ($i = 1; $i <= 12; $i++) {
          $compraw[] = $cyear . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
        }
 
        $currentYearData = [];
        foreach ($compraw as $valuey) {
          $donequery = mysqli_query($con, "SELECT DATE_FORMAT(compdate, '%Y-%m') AS complaint_month, COUNT(*) AS total_complaints FROM tblnewcomplaint WHERE DATE_FORMAT(compdate, '%Y-%m') = '$valuey' GROUP BY complaint_month");
          $dom = mysqli_fetch_array($donequery);
          $donen = mysqli_num_rows($donequery);
          $currentYearData[$valuey] = ($donen > 0) ? (int)$dom['total_complaints'] : 0;
        }
 
        $currentYearPoints = [];
        $currentMonth = date('n'); // Current month as number (1-12)
        foreach ($compraw as $index => $monthValue) {
          $monthNumber = $index + 1;
          $monthName = date("M", strtotime($monthValue . '-01'));
          $currentY = ($monthNumber <= $currentMonth) ? $currentYearData[$monthValue] : null;
          $currentYearPoints[] = ["label" => $monthName, "y" => $currentY];
        }
 
        $chartLabels = [];
        $chartValues = [];
        foreach ($currentYearPoints as $pt) {
          $chartLabels[] = $pt['label'];
          $chartValues[] = is_null($pt['y']) ? null : (int)$pt['y'];
        }
        ?>
        <h5 class="card-title">Monthly Complaints - <?php echo $cyear; ?></h5>
        <canvas id="chartContainerx" style="height: 400px; width: 100%;"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
          (function(){
            const labels = <?php echo json_encode($chartLabels); ?>;
            const dataValues = <?php echo json_encode($chartValues); ?>;
            const ctx = document.getElementById('chartContainerx').getContext('2d');
            new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Current Year (<?php echo $cyear; ?>)',
              data: dataValues,
              backgroundColor: '#369EAD',
              borderColor: '#2e8b90',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              x: { title: { display: true, text: 'Month' } },
              y: { beginAtZero: true, title: { display: true, text: 'Number of Complaints' } }
            },
            plugins: {
              legend: { display: true },
              tooltip: { mode: 'index', intersect: false }
            }
          }
            });
          })();
        </script>
          </div>
        </div>
      </div>

      <!-- complaint trending end -->




      <!-- <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
              <div class="card-body">
                <div class="card-title">Service Supplier KPI <a href="admin.php?id=service-analysis"><button class="btn btn-primary" style="float:right">View</button></a></div>


                <table class="display table table-striped table-bordered" id="zero_configuration_table"
                  style="width:100%">
                  <thead>
                    <tr class="text-center">
                      <th width="28">SR No.</th>
                      <th width="48">Supplier Name</th>
                      <th width="48">Basis of Aproval</th>

                      <?php


                      $cyear = date("Y");




                      $riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';




                      $riskarr = explode(',', $riskstr);
                      foreach ($riskarr as $key => $value) {
                        $dateString = $value;
                        $timestamp = strtotime($dateString); // Prepend a day to make it a valid date
                        $formattedDate = date("M Y", $timestamp); // Format the timestamp to "Nov 2024"

                      ?>

                        <th width="48"><?php
                                        echo $formattedDate; ?></th>
                      <?php
                      }
                      ?>

                    </tr>
                  </thead>
                  <tbody>
                    <?php


                    $sp = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype = 'Service Supplier'");
                    $i = 0;
                    foreach ($sp as $spr) {
                      $i++;
                      $supnm = $spr['supname']; ?>
                      <tr>
                        <td width="28"><?php echo $i; ?></td>
                        <td width="48"><?php echo $spr['supname']; ?></td>
                        <td width="48"><?php echo $spr['approval']; ?></td>



                        <?php
                        foreach ($riskarr as $key1 => $value1) {

                          $sup1 = mysqli_query($con, " SELECT 
                            supplier, 
                            DATE_FORMAT(date, '%Y-%m') AS complaint_month,
                            COUNT(*) AS total_complaints
                        FROM 
                            tblsuppliercomplaint
                        WHERE 
                            DATE_FORMAT(date, '%Y-%m') = '$value1'
                            AND supplier = '$supnm'
                        GROUP BY 
                            supplier, complaint_month;
                     ");
                          $cmpdt = mysqli_fetch_array($sup1);
                          $count = mysqli_num_rows($sup1);  //get count row in query
                          //  echo $count;
                          if ($count == 0) {
                            $totalcomp = 0;
                          } else {
                            $totalcomp = $cmpdt['total_complaints'];
                          }


                        ?>
                          <td width="48"><?php echo $totalcomp; ?></td>





                        <?php

                        }
                        ?>
                      </tr>
                    <?php
                    }

                    ?>