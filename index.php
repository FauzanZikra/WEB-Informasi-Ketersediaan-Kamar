<?php
session_start();
require_once('conf/conf.php');

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Error reporting
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 0);

date_default_timezone_set("Asia/Bangkok");

// Cek koneksi database
if (!function_exists('bukaquery')) {
    die("Error: Database connection function not found!");
}

// Include header
include('template/header.php');
?>



<?php
// Summary Cards
$summary_sql = "SELECT 
                  COUNT(*) as total_bed,
                  SUM(CASE WHEN status = 'ISI' THEN 1 ELSE 0 END) as total_occupied,
                  SUM(CASE WHEN status = 'KOSONG' THEN 1 ELSE 0 END) as total_available
               FROM kamar 
               WHERE statusdata = '1'";

$summary_result = bukaquery($summary_sql);
$summary = mysqli_fetch_array($summary_result);
?>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card total">
        <i class="fas fa-bed summary-icon"></i>
        <div class="summary-number"><?php echo $summary['total_bed'] ?? 0; ?></div>
        <div class="summary-label">Total Bed</div>
    </div>
    
    <div class="summary-card occupied">
        <i class="fas fa-user-injured summary-icon"></i>
        <div class="summary-number"><?php echo $summary['total_occupied'] ?? 0; ?></div>
        <div class="summary-label">Bed Terisi</div>
    </div>
    
    <div class="summary-card available">
        <i class="fas fa-door-open summary-icon"></i>
        <div class="summary-number"><?php echo $summary['total_available'] ?? 0; ?></div>
        <div class="summary-label">Bed Tersedia</div>
    </div>
</div>

<!-- Room Availability Table -->
<div class="room-status-card fade-in">
    <div class="card-header-custom">
        <i class="fas fa-clipboard-list me-2"></i> KETERSEDIAAN KAMAR PER KELAS
    </div>
    <div class="table-responsive">
        <table class="status-table">
            <thead>
                <tr>
                    <th>KELAS KAMAR</th>
                    <th>JUMLAH BED</th>
                    <th>BED TERISI</th>
                    <th>BED KOSONG</th>
                    <th>KETERSEDIAAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT 
                          kelas,
                          COUNT(*) as total_bed,
                          SUM(CASE WHEN status = 'ISI' THEN 1 ELSE 0 END) as terisi,
                          SUM(CASE WHEN status = 'KOSONG' THEN 1 ELSE 0 END) as kosong
                        FROM kamar 
                        WHERE statusdata = '1'
                        GROUP BY kelas
                        ORDER BY 
                          CASE kelas
                            WHEN 'VIP' THEN 1
                            WHEN 'Kelas 1' THEN 2
                            WHEN 'Kelas 2' THEN 3
                            WHEN 'Kelas 3' THEN 4
                            ELSE 5
                          END";
                
                $hasil = bukaquery($sql);
                $counter = 0;
                
                while ($data = mysqli_fetch_array($hasil)) {
                    $counter++;
                    $availability_percent = ($data['total_bed'] > 0) ? round(($data['kosong'] / $data['total_bed']) * 100) : 0;
                    
                    if ($availability_percent >= 50) {
                        $availability_class = 'success';
                        $availability_text = 'Banyak Tersedia';
                    } elseif ($availability_percent >= 20) {
                        $availability_class = 'warning';
                        $availability_text = 'Terbatas';
                    } else {
                        $availability_class = 'success';
                        $availability_text = 'Tersedia';
                    }
                    
                    echo "<tr>";
                    echo "<td><span class='kelas-badge'>" . htmlspecialchars($data['kelas']) . "</span></td>";
                    echo "<td><span class='total-count'>" . $data['total_bed'] . "</span></td>";
                    echo "<td><span class='occupied-count'>" . $data['terisi'] . "</span></td>";
                    echo "<td><span class='available-count'>" . $data['kosong'] . "</span></td>";
                    echo "<td>
                            <div class='availability-indicator'>
                                <span class='indicator-dot dot-$availability_class'></span>
                                <span>$availability_text ($availability_percent%)</span>
                            </div>
                          </td>";
                    echo "</tr>";
                }
                
                if ($counter == 0) {
                    echo "<tr>
                            <td colspan='5' style='text-align: center; padding: 40px; color: #666;'>
                                <i class='fas fa-database fa-3x mb-3' style='color: #ddd;'></i><br>
                                Tidak ada data kamar tersedia
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Include footer
include('template/footer.php');
?>