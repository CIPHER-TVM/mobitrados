<p style="font-size:14px;font-family: Arial, Helvetica, sans-serif;text-align: justify">
<Br />
<?php
  if($r)
  {
    $alumniName=$r->alumniName;
      if($r->otherQualifications)
      {
        echo "<ul>
          <li>$r->otherQualifications</li>
          ";
      }
      if($r->specialProfessional)
      {
        echo "<li>
        $r->specialProfessional
        </li>";
      }
      echo "</ul>"
    ?>
    <b style="font-size: 18px">Designation</b> <br />
    <?php
      echo " <ul>";
      if($r->medicalDesignation )
      {
          echo "<li>$r->medicalDesignation  </li>
            <li>$r->institution  </li>
          ";
      }
      echo "</ul>";
      ?>
        <b style="font-size: 18px">  Research Publications</b> <br />
        <ol>

          <?php
            if($r->typeOfArticle1)
            {
              echo "<li>
              $r->typeOfArticle1  $r->articleKeywords1, $r->articleDetails1;
              </li>";
            }
            if($r->typeOfArticle2)
            {
              echo "<li>
              $r->typeOfArticle2  $r->articleKeywords2, $r->articleDetails2;
              </li>";
            }
            if($r->typeOfArticle3)
            {
              echo "<li>
              $r->typeOfArticle3  $r->articleKeywords3, $r->articleDetails3;
              </li>";
            }
           ?>

        </ol>

        <b style="font-size: 18px">  Other Details</b> <br /> <br />
        <?php
        if($r->personalLife)
        {
          echo "<b>Personal Life </b> <br /> <br />
          $r->personalLife <br /><br />";
        }
        if($r->work)
        {
          echo "<b>Work </b> <br /> <br />
          $r->work <br /><br />";
        }
        if($r->hobbies)
        {
          echo "<b>Hobbies </b> <br /><br />
          $r->hobbies <br /><br />";
        }

        if($r->awards)
        {
          echo "<b>Awards and Other Recognitions </b> <br /><br />
          $r->awards <br />
          <br />";
        }

        if($r->anyOther)
        {
          echo "<b>Any relevant information not covered above. </b> <br /><br />
          $r->anyOther <br />
          <br />";
        }

        echo "<b>Contact information</b> <br />
          <ul>";

          if($r->primaryMobile)
          {
            echo "<li> $r->primaryMobile </li>";
          }
          if($r->alternateMobile)
          {
            echo "<li> $r->alternateMobile </li>";
          }
          if($r->landline)
          {
            echo "<li> $r->landline </li>";
          }
          if($r->socialNetworking)
          {
            echo "<li> $r->socialNetworking </li>";
          }
          if($r->emailid)
          {
            echo "<li> $r->emailid </li>";
          }
          if($r->website)
          {
            echo "<li> $r->website </li>";
          }

        echo " </ul>
        ";


  }
 ?>

</p>
