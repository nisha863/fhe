import { db } from '$lib/server/db';
import { json } from '@sveltejs/kit';
import fs from 'fs/promises';
import path from 'path';

async function ensureDirExists(dir) {
  try {
    await fs.mkdir(dir, { recursive: true });
  } catch (e) {
    // Directory may already exist
  }
}

async function getAvailableFilename(basePath, baseName, ext) {
  let filename = `${baseName}.${ext}`;
  let counter = 1;
  while (true) {
    try {
      await fs.access(path.join(basePath, filename));
      // File exists, try next
      filename = `${baseName}_${counter}.${ext}`;
      counter++;
    } catch {
      // File does not exist
      return filename;
    }
  }
}

export async function POST({ request }) {
  const formData = await request.formData();

  // Extract fields from formData
  const fullname = formData.get('fullname');
  const id = formData.get('id');
  const date_of_application = formData.get('date_of_application');
  const address = formData.get('address');
  const sex = formData.get('sex');
  const civil_status = formData.get('civil_status');
  const phone = formData.get('phone');
  const email = formData.get('email');
  const course = formData.get('course');
  const year_level = formData.get('year_level');
  const type_student = formData.get('type_student');
  const school_name_last_attended = formData.get('school_name_last_attended');
  const year_last_attended = formData.get('year_last_attended');
  const scholarship = formData.get('scholarship');
  const scholarship_name = formData.get('scholarship_name');
  const mother_name = formData.get('mother_name');
  const father_name = formData.get('father_name');
  const mother_occupation = formData.get('mother_occupation');
  const father_occupation = formData.get('father_occupation');
  const mother_income = formData.get('mother_income');
  const father_income = formData.get('father_income');
  const student_signature = formData.get('student_signature');
  const guardian_signature = formData.get('guardian_signature');
  const guardian_name = formData.get('guardian_name');
  const guardian_relationship = formData.get('guardian_relationship');
  // For image, store as base64 string or handle as needed
  let student_picture = formData.get('student_picture');
  let student_picture_path = '';
  const uploadsDir = path.join('static', 'uploads');
  await ensureDirExists(uploadsDir);
  // Save student picture
  if (student_picture && typeof student_picture === 'object' && student_picture.name) {
    const buffer = Buffer.from(await student_picture.arrayBuffer());
    const ext = student_picture.name.split('.').pop() || 'png';
    const baseName = `${id}-${date_of_application}-pic`;
    const filename = await getAvailableFilename(uploadsDir, baseName, ext);
    const uploadPath = path.join(uploadsDir, filename);
    await fs.writeFile(uploadPath, buffer);
    student_picture_path = `/uploads/${filename}`;
  }
  // Save student_signature as image if it's a data URL
  let student_signature_path = '';
  if (typeof student_signature === 'string' && student_signature.startsWith('data:image/')) {
    const ext = student_signature.substring(11, student_signature.indexOf(';')) || 'png';
    const baseName = `${id}-${date_of_application}-sign`;
    const filename = await getAvailableFilename(uploadsDir, baseName, ext);
    const uploadPath = path.join(uploadsDir, filename);
    const base64Data = student_signature.split(',')[1];
    await fs.writeFile(uploadPath, Buffer.from(base64Data, 'base64'));
    student_signature_path = `/uploads/${filename}`;
  }
  // Save guardian_signature as image if it's a data URL
  let guardian_signature_path = '';
  if (typeof guardian_signature === 'string' && guardian_signature.startsWith('data:image/')) {
    const ext = guardian_signature.substring(11, guardian_signature.indexOf(';')) || 'png';
    const baseName = `${id}-${date_of_application}-g_sign`;
    const filename = await getAvailableFilename(uploadsDir, baseName, ext);
    const uploadPath = path.join(uploadsDir, filename);
    const base64Data = guardian_signature.split(',')[1];
    await fs.writeFile(uploadPath, Buffer.from(base64Data, 'base64'));
    guardian_signature_path = `/uploads/${filename}`;
  }

  try {
    const [result] = await db.execute(
      `INSERT INTO students (
        fullname, id_number, address, sex, civil_status, phone, email, course, year_level, type_student,
        school_name_last_attended, year_last_attended, scholarship, scholarship_name,
        mother_name, father_name, mother_occupation, father_occupation, mother_income, father_income,
        student_signature, guardian_signature, guardian_name, guardian_relationship, student_picture, date_of_application
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [
        fullname, id, address, sex, civil_status, phone, email, course, year_level, formData.get('type_student'),
        formData.get('school_name_last_attended'), formData.get('year_last_attended'), formData.get('scholarship'), formData.get('scholarship_name'),
        formData.get('mother_name'), formData.get('father_name'), formData.get('mother_occupation'), formData.get('father_occupation'), formData.get('mother_income'), formData.get('father_income'),
        student_signature_path, guardian_signature_path, formData.get('guardian_name'), formData.get('guardian_relationship'), student_picture_path, formData.get('date_of_application')
      ]
    );
    return json({ success: true, message: 'Student data saved successfully.' });
  } catch (error) {
    console.error('DB or server error:', error);
    return json({ success: false, error: error.message }, { status: 500 });
  }
}

export async function GET() {
  try {
    const [rows] = await db.query('SELECT * FROM students ORDER BY date_of_application DESC');
    return json(rows);
  } catch (error) {
    console.error('DB or server error:', error);
    return json({ success: false, error: error.message }, { status: 500 });
  }
}
