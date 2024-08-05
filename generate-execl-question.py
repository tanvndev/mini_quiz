import pandas as pd

# Create a new DataFrame for the geography questions
geography_data = {
    'Question': [
        "Đỉnh núi cao nhất ở Việt Nam là đỉnh nào?",
        "Sông nào dài nhất Việt Nam?",
        "Vịnh nào được UNESCO công nhận là Di sản thiên nhiên thế giới?",
        "Biển Đông bao bọc Việt Nam ở phía nào?",
        "Thủ đô của Việt Nam là thành phố nào?",
        "Hồ nào lớn nhất ở Hà Nội?",
        "Việt Nam nằm ở khu vực nào của châu Á?",
        "Đồng bằng lớn nhất ở Việt Nam là đồng bằng nào?",
        "Việt Nam có bao nhiêu tỉnh thành?",
        "Núi Bà Đen thuộc tỉnh nào?",
        "Đèo nào dài nhất Việt Nam?",
        "Huyện đảo Trường Sa thuộc tỉnh nào?",
        "Tỉnh nào có diện tích lớn nhất Việt Nam?",
        "Thành phố nào lớn nhất Việt Nam?",
        "Sông Hương chảy qua tỉnh nào?",
        "Núi Bạch Mã thuộc tỉnh nào?",
        "Quốc gia nào không có chung biên giới với Việt Nam?",
        "Đảo Phú Quốc thuộc tỉnh nào?",
        "Đèo Hải Vân nối liền hai tỉnh nào?",
        "Sông Cửu Long chảy qua bao nhiêu tỉnh thành ở Việt Nam?"
    ],
    'A': [
        "Đỉnh Phan Xi Păng", "Sông Mê Kông", "Vịnh Hạ Long", "Phía Đông", "Hà Nội", "Hồ Tây", "Đông Á", "Đồng bằng sông Hồng", "61", "Tây Ninh", "Đèo Hải Vân", "Khánh Hòa", "Nghệ An", "Hà Nội", "Thừa Thiên Huế", "Thừa Thiên Huế", "Trung Quốc", "Kiên Giang", "Thừa Thiên Huế và Quảng Nam", "10"
    ],
    'B': [
        "Đỉnh Tây Côn Lĩnh", "Sông Hồng", "Vịnh Lan Hạ", "Phía Tây", "TP. Hồ Chí Minh", "Hồ Hoàn Kiếm", "Đông Nam Á", "Đồng bằng sông Cửu Long", "63", "Bình Dương", "Đèo Ngang", "Bình Thuận", "Gia Lai", "Đà Nẵng", "Quảng Bình", "Quảng Bình", "Lào", "An Giang", "Đà Nẵng và Quảng Ngãi", "12"
    ],
    'C': [
        "Đỉnh Pu Si Lung", "Sông Đà", "Vịnh Xuân Đài", "Phía Nam", "Đà Nẵng", "Hồ Trúc Bạch", "Nam Á", "Đồng bằng Trung Bộ", "64", "Ninh Thuận", "Đèo Cả", "Ninh Thuận", "Đồng Nai", "Cần Thơ", "Đà Nẵng", "Quảng Ngãi", "Campuchia", "Cà Mau", "Quảng Ngãi và Bình Định", "13"
    ],
    'D': [
        "Đỉnh Ngọc Linh", "Sông Đồng Nai", "Vịnh Cam Ranh", "Phía Bắc", "Huế", "Hồ Bảy Mẫu", "Tây Á", "Đồng bằng Bắc Bộ", "65", "Bình Phước", "Đèo Pha Đin", "Phú Yên", "Kon Tum", "Hải Phòng", "Hà Tĩnh", "Quảng Nam", "Thái Lan", "Bình Thuận", "Đà Nẵng và Thừa Thiên Huế", "14"
    ],
    'E': [None] * 20,
    'F': [None] * 20,
    'Topic': [1] * 20,
    'Type': [1] * 20,
    'correct': ["A", "B", "A", "A", "A", "A", "B", "B", "B", "A", "A", "A", "A", "B", "A", "A", "D", "A", "D", "B"]
}

geography_df = pd.DataFrame(geography_data)

# Save the DataFrame to a new Excel file
geography_output_file_path = 'question-bank-vietnam-geography.xlsx'
geography_df.to_excel(geography_output_file_path, index=False)

print(f'File saved to {geography_output_file_path}')