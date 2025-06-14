from flask import Flask, render_template, request, redirect, url_for, flash
from flask_sqlalchemy import SQLAlchemy
from flask_wtf import FlaskForm
from wtforms import StringField, PasswordField, SubmitField
from wtforms.validators import DataRequired, Email, EqualTo, Length

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your_secret_key'  # Ganti dengan secret key yang kuat
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///users.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

# --- Model Database ---
class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password_hash = db.Column(db.String(128)) # Simpan hash password, bukan password asli

    def __repr__(self):
        return f'<User {self.username}>'

# --- Forms ---
class RegistrationForm(FlaskForm):
    username = StringField('Username', validators=[DataRequired(), Length(min=4, max=25)])
    email = StringField('Email', validators=[DataRequired(), Email()])
    password = PasswordField('Password', validators=[DataRequired(), Length(min=6)])
    confirm_password = PasswordField('Confirm Password', validators=[DataRequired(), EqualTo('password')])
    submit = SubmitField('Register')

class UpdateUserForm(FlaskForm):
    username = StringField('Username', validators=[DataRequired(), Length(min=4, max=25)])
    email = StringField('Email', validators=[DataRequired(), Email()])
    submit = SubmitField('Update User')

# --- Routes ---
@app.route('/')
def index():
    return redirect(url_for('register'))

@app.route('/register', methods=['GET', 'POST'])
def register():
    form = RegistrationForm()
    if form.validate_on_submit():
        # Untuk sekarang, kita tidak meng-hash password, tapi ini penting untuk produksi
        # from werkzeug.security import generate_password_hash
        # hashed_password = generate_password_hash(form.password.data, method='pbkdf2:sha256')
        
        existing_user_by_username = User.query.filter_by(username=form.username.data).first()
        existing_user_by_email = User.query.filter_by(email=form.email.data).first()

        if existing_user_by_username:
            flash('Username already exists. Please choose a different one.', 'danger')
            return render_template('register.html', title='Register', form=form)
        
        if existing_user_by_email:
            flash('Email address already registered. Please use a different one.', 'danger')
            return render_template('register.html', title='Register', form=form)

        new_user = User(username=form.username.data, email=form.email.data, password_hash=form.password.data) # Simpan password langsung (TIDAK AMAN)
        db.session.add(new_user)
        db.session.commit()
        flash(f'Account created for {form.username.data}!', 'success')
        return redirect(url_for('user_list'))
    return render_template('register.html', title='Register', form=form)

@app.route('/users')
def user_list():
    users = User.query.all()
    return render_template('users.html', title='Registered Users', users=users)

@app.route('/user/<int:user_id>/update', methods=['GET', 'POST'])
def update_user(user_id):
    user = User.query.get_or_404(user_id)
    form = UpdateUserForm(obj=user) # Pre-populate form dengan data user
    if form.validate_on_submit():
        # Cek apakah username atau email baru sudah digunakan oleh user lain
        is_username_taken = User.query.filter(User.id != user_id, User.username == form.username.data).first()
        is_email_taken = User.query.filter(User.id != user_id, User.email == form.email.data).first()

        if is_username_taken:
            flash('That username is already taken by another user. Please choose a different one.', 'danger')
            return render_template('update_user.html', title='Update User', form=form, user_id=user_id)
        
        if is_email_taken:
            flash('That email address is already registered by another user. Please use a different one.', 'danger')
            return render_template('update_user.html', title='Update User', form=form, user_id=user_id)

        user.username = form.username.data
        user.email = form.email.data
        db.session.commit()
        flash('User details have been updated!', 'success')
        return redirect(url_for('user_list'))
    return render_template('update_user.html', title='Update User', form=form, user_id=user_id)


@app.route('/user/<int:user_id>/delete', methods=['POST']) # Hanya terima POST untuk delete
def delete_user(user_id):
    user = User.query.get_or_404(user_id)
    db.session.delete(user)
    db.session.commit()
    flash('User has been deleted!', 'success')
    return redirect(url_for('user_list'))

if __name__ == '__main__':
    with app.app_context():
        db.create_all() # Buat tabel database jika belum ada
    app.run(debug=True)
