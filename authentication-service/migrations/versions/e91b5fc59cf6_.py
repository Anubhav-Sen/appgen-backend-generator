"""empty message

Revision ID: e91b5fc59cf6
Revises: e1e024b21323
Create Date: 2024-11-18 20:55:06.774156

"""
from typing import Sequence, Union

from alembic import op
import sqlalchemy as sa
import sqlmodel


# revision identifiers, used by Alembic.
revision: str = 'e91b5fc59cf6'
down_revision: Union[str, None] = 'e1e024b21323'
branch_labels: Union[str, Sequence[str], None] = None
depends_on: Union[str, Sequence[str], None] = None


def upgrade() -> None:
    pass


def downgrade() -> None:
    pass
