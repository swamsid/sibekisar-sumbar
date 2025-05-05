<!-- Periode < 2024 -->
BEGIN
	#Routine body goes here...
	replace vw_rekap_by_aspek
	SELECT
	* , (tmp.nilai_akhir*tmp.nilai_maks)/100 as total_nilai
FROM
	(
	SELECT
	evaluasi.tahun as tahun,
	evaluasi.id_unit,
		m_unit.unit ,
		m_aspek.tag,		
		m_aspek.id_aspek,
		m_aspek.aspek,		
		Sum( evaluasi.nilai_akhir ) AS nilai_akhir,
		Avg( evaluasi.nilai_maks ) AS nilai_maks
		
	FROM
		evaluasi
		INNER JOIN m_indikator ON m_indikator.id_indikator = evaluasi.id_indikator
		INNER JOIN m_aspek ON m_indikator.id_aspek = m_aspek.id_aspek
		INNER JOIN m_unit ON m_unit.id_unit = evaluasi.id_unit 
		WHERE m_indikator.is_Aktif=1
		AND m_indikator.periode < 3
	GROUP BY
		m_aspek.id_aspek,
		m_aspek.aspek,
		evaluasi.tahun,
		evaluasi.id_unit,
	m_unit.unit 
	) AS tmp;

END