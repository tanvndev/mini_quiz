import pandas as pd

# Dữ liệu câu hỏi hóa học với tất cả các danh sách có cùng độ dài
chemistry_data = {
    'Question': [
        "Chất nào là axit mạnh nhất trong các axit sau: HCl, H2SO4, HNO3, H2CO3?",
        "Nguyên tố nào có số hiệu nguyên tử là 6?",
        "Chất nào là dung môi phổ biến nhất trong hóa học?",
        "Đơn vị đo khối lượng phân tử là gì?",
        "Chất nào được biết đến là tác nhân oxi hóa mạnh?",
        "Phản ứng nào giữa kim loại và acid tạo ra khí hidro?",
        "Axit nào có mặt trong dạ dày người?",
        "Nguyên tố nào có ký hiệu là O?",
        "Chất nào được sử dụng trong việc làm tinh bột?",
        "Nước có công thức hóa học là gì?",
        "Khí nào được gọi là khí thở?",
        "Chất nào dùng để làm sạch nước uống?",
        "Hợp chất nào được tạo thành từ các nguyên tử oxy và hydro?",
        "Chất nào được gọi là chất điện ly mạnh?",
        "Hàm lượng oxi trong không khí chiếm bao nhiêu phần trăm?",
        "Nguyên tố nào là thành phần chính của nước biển?",
        "Axit nào được sử dụng trong việc sản xuất phân bón?",
        "Kim loại nào được sử dụng nhiều trong ngành công nghiệp chế tạo máy móc?",
        "Chất nào được dùng để làm thuốc nhuộm thực phẩm?"
    ],
    'A': [
        "H2SO4", "Carbon", "Nước", "Gram", "Oxy", "Kali", "HCl", "Oxy", "Tinh bột", "H2O", "CO2", "Clorua", "Natri", "Natri", "21%", "Sodium", "HNO3", "Sắt", "Axit tartric"
    ],
    'B': [
        "HNO3", "Oxy", "Cồn", "Kilogram", "Clorua", "Magie", "H2SO4", "Kali", "Đường", "NaCl", "Oxy", "Khí ozon", "Barium", "Calci", "78%", "Clorua", "H2SO4", "Nhôm", "Axit sulfuric"
    ],
    'C': [
        "HCl", "Nitơ", "Aceton", "Mole", "Natri", "Sắt", "H2CO3", "Hydro", "Axit", "NaOH", "Khí metan", "Natri clorua", "Sắt", "Đồng", "70%", "Magie", "HCl", "Bạc", "Axit acetic"
    ],
    'D': [
        "H2CO3", "Hydro", "Amoniac", "MiliGram", "Amoniac", "Kẽm", "HNO3", "Cacbon", "Chất béo", "HCl", "Khí nitơ", "Natri bicacbonat", "Kẽm", "Kali", "90%", "Canxi", "Axit acetic", "Kẽm", "Axit citric"
    ],
    'E': [None] * 19,
    'F': [None] * 19,
    'Topic': [3] * 19,
    'Type': [1] * 19,
    'correct': ["A", "A", "A", "D", "B", "A", "A", "A", "A", "A", "B", "B", "C", "D", "A", "B", "A", "B", "B"]
}

# Kiểm tra độ dài của tất cả các danh sách
lengths = {key: len(value) for key, value in chemistry_data.items()}
print("Lengths of each list in the dictionary:", lengths)

# Tạo DataFrame từ dữ liệu
chemistry_df = pd.DataFrame(chemistry_data)

# Lưu DataFrame vào một tệp Excel mới
chemistry_output_file_path = 'question-bank-vietnam-chemistry.xlsx'
chemistry_df.to_excel(chemistry_output_file_path, index=False)

print(f'File saved to {chemistry_output_file_path}')
