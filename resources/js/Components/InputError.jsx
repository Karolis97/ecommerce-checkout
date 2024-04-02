import PropTypes from 'prop-types'

function InputError({ errors, field }) {
    return errors?.[field]?.length &&
        <div className="text-sm text-red-600">
            <ul>
                { errors[field].map((error, index) => {
                    return (<li key={ index }>{ error }</li>)
                }) }
            </ul>
        </div>
}

InputError.propTypes = {
    errors: PropTypes.object.isRequired,
    field: PropTypes.string.isRequired,
}

export default InputError
