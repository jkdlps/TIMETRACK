<!-- Display a table of daily time record change requests -->
<table>
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Old Time In</th>
            <th>New Time In</th>
            <th>Old Time Out</th>
            <th>New Time Out</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT dtr_changes.id, employees.name, dtr_changes.old_time_in, dtr_changes.new_time_in, dtr_changes.old_time_out, dtr_changes.new_time_out, dtr_changes.reason 
                  FROM dtr_changes 
                  JOIN employees ON dtr_changes.employee_id = employees.id 
                  WHERE dtr_changes.status = 'Pending'";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>'.$row['name'].'</td>';
            echo '<td>'.$row['old_time_in'].'</td>';
            echo '<td>'.$row['new_time_in'].'</td>';
            echo '<td>'.$row['old_time_out'].'</td>';
            echo '<td>'.$row['new_time_out'].'</td>';
            echo '<td>'.$row['reason'].'</td>';
            echo '<td><button onclick="openModal(\'approvalModal_'.$row['id'].'\')">Approve/Deny</button></td>';
            echo '</tr>';

            // Display a modal form to confirm the approval or denial of the request
            echo '<div id="approvalModal_'.$row['id'].'" class="modal" style="display: none;">
                      <div class="modal-content">
                          <span class="close" onclick="closeModal()">&times;</span>
                          <h2>Approval Request</h2>
                          <form method="post">
                              <input type="hidden" name="change_id" value="'.$row['id'].'">
                              <label for="status">Status:</label>
                              <select name="status" required>
                                  <option value="Approved">Approve</option>
                                  <option value="Denied">Deny</option>
                              </select><br><br>
                              <label for="comment">Comment:</label>
                              <textarea name="comment" rows="3"></textarea><br><br>
                              <button type="submit">Submit</button>
                              <button type="button" onclick="closeModal()">Cancel</button>
                          </form>
                      </div>
                  </div>';
        }
        ?>
    </tbody>
</table>
