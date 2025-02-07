<?php
require_once __DIR__ . '/../Models/Reservation.php';

class ExportController {

    private $reservationModel;

    public function __construct() {
        $this->reservationModel = new Reservation();
    }

    // Метод для экспорта всех резерваций в CSV
    public function exportReservations() { //READ
        $reservations = $this->reservationModel->getAllReservations();
        $filename = "reservations_" . date("Y_m_d_H_i_s") . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $output = fopen('php://output', 'w');

        // Заголовки CSV
        fputcsv($output, ['Užívateľ', 'Email', 'Služba', 'Dátum', 'Čas']);

        // Данные
        foreach ($reservations as $reservation) {
            fputcsv($output, [
                $reservation['user_name'],
                $reservation['user_email'],
                $reservation['service_name'],
                $reservation['reservation_date'],
                $reservation['reservation_time'],
            ]);
        }

        fclose($output);
        exit;
    }
}
?>
